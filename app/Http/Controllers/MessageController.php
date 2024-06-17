<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function create(Request $request)
    {
        // $users = User::whereNot('id', auth()->id())->orderBy('id', 'desc')->get();
        $friend_fio = $request->friend_fio;
        $user = User::latest('id')->first();
        $friends = Friend::where('user1_id', auth()->id())
            ->whereHas('user2', function ($innerQuery) use ($friend_fio) {
                $innerQuery->where('fio', 'LIKE', "%$friend_fio%");
            })
            ->with('user2')
            ->get()
            ->map(function ($friend) {
                $msg_cnt = Message::where('sendler_user_id', auth()->id())
                    ->where('user_id', $friend->user2_id)
                    ->where('is_cheked', 0)
                    ->count();
                $friend->msg_cnt = $msg_cnt;
                return $friend;
            });
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

        $friends = Friend::where('user1_id', $me)
            ->with('user2')
            ->get()
            ->map(function ($friend) {
                $msg_cnt = Message::where('sendler_user_id', auth()->id())
                    ->where('user_id', $friend->user2_id)
                    ->where('is_cheked', 0)
                    ->count();
                $friend->msg_cnt = $msg_cnt;
                return $friend;
            });
        foreach ($messages as $message) {
            $message->svg = $message->getSvgIcon();
            $message->extension = strtolower(pathinfo($message->file_name, PATHINFO_EXTENSION));
        }
        Message::where('sendler_user_id', $me)->where('is_cheked', 0)->where('user_id', $id)->update([
            'is_cheked' => 1,
        ]);
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

    public function messanger(Request $request)
    {
        $query = $request->input('query');
        $friends = Friend::where('user1_id', auth()->id())
            ->whereHas('user2', function ($innerQuery) use ($query) {
                $innerQuery->where('fio', 'LIKE', "%$query%");
            })
            ->with('user2')
            ->get();

        $friendIds = $friends->pluck('user2.id')->toArray();

        $otherUsers = User::where('id', '!=', auth()->id())
            ->where(function ($userQuery) use ($friendIds) {
                $userQuery->whereNotIn('id', $friendIds);
            })
            ->orderBy('id', 'desc')->get();

        return view('chats.messanger', compact('friends', 'otherUsers'));
    }
}
