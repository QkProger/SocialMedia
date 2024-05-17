<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function create()
    {
        // $messages = null;
        $users = User::whereNot('id', auth()->id())->orderBy('created_at', 'desc')->get();
        $user = User::latest('id')->first();
        // return view('chats.chat', compact('messages', 'users', 'user'));
        $friends = Friend::where('user1_id', auth()->id())
            ->with('user2')
            ->get();
        return view('chats.chat', compact('friends', 'user'));
    }

    public function downloadFile($id)
    {
        $file = Message::findOrFail($id);

        $filePath = storage_path('app/chat_files/' . $file->file_name);

        return response()->download($filePath, $file->file_name);
    }

    public function getAudioFile($filename)
    {
        $path = storage_path('app/audio_messages/' . $filename);

        if (file_exists($path)) {
            return response()->file($path, ['Content-Type' => 'audio/webm']);
        } else {
            abort(404);
        }
    }

    public function loadChat($id)
    {
        $user = User::findOrFail($id);
        $me = auth()->id();
        $messages = Message::where(function ($q) use ($id) {
            $q->where('user_id', $id)->orWhere('sendler_user_id', $id);
        })->where(function ($q) use ($me) {
            $q->where('user_id', $me)->orWhere('sendler_user_id', $me);
        })
            ->orderBy('created_at')
            ->get();
        // $users = User::whereNot('id', auth()->id())->orderBy('created_at', 'desc')->get();

        $friends = Friend::where('user1_id', $me)
            ->with('user2')
            ->get();
        return view('chats.chat', compact('messages', 'user', 'friends'));
    }

    public function store(Request $request)
    {
        $data['user_id'] = auth()->id();
        $data['sendler_user_id'] = $request->sendler_user_id;

        if ($request->hasFile('file_name')) {
            $request->validate([
                'message' => 'nullable|string',
                'file_name' => 'sometimes|file|max:102400',
                'audio_file' => 'nullable|max:102400',
            ]);
            if ($request->message) {
                $data['message'] = $request->message;
            } else {
                $data['message'] = '';
            }
            $file = $request->file('file_name');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('chat_files', $fileName);

            $data['file_name'] = $fileName;
            $data['audio_file_path'] = '';
        } else if ($request->hasFile('audio_file')) {
            $request->validate([
                'audio_file' => 'file|max:102400',
                'message' => 'nullable|string',
                'file_name' => 'nullable|sometimes|file|max:102400',
            ]);

            $audioFile = $request->file('audio_file');
            // $audioFileName = $audioFile->getClientOriginalName();
            // $audioFile->storeAs('audio_messages', $audioFileName);
            $audioFileName = 'audio_' . time() . '.' . $audioFile->guessExtension();

            $audioFile->storeAs('audio_messages', $audioFileName);


            $data['audio_file_path'] = $audioFileName;
            $data['message'] = '';
            $data['file_name'] = '';
        } else {
            $request->validate([
                'message' => 'sometimes|string',
            ]);
            $data['message'] = $request->message;
            $data['file_name'] = '';
            $data['audio_file_path'] = '';
        }
        // Создание новой записи в базе данных
        $messages = Message::create($data);

        // Возвращение JSON-ответа
        return response()->json(['success' => 'Сообщение успешно отправлено!', 'message' => $messages]);
    }

    public function update(Request $request, Message $message)
    {
        if ($message->user_id == auth()->id()) {
            $request->validate([
                'editedMessage' => 'required|string',
            ]);
            $message->update([
                'message' => $request->input('editedMessage'),
            ]);

            return redirect()->back()->with('success', 'Сообщение успешно отредактировано.');
        } else {
            return redirect()->back()->with('error', 'У вас нет прав на редактирование этого сообщения.');
        }
    }

    public function destroy(Message $message)
    {
        $message->delete();
        if ($message->file_name) {
            Storage::delete('chat_files/' . $message->file_name);
        }
        return back()->with('success', 'Сообщение успешно удалено.');
    }
}
