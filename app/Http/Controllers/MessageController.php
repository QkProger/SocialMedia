<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function create()
    {
        $messages = null;
        $users = User::whereNot('id', auth()->id())->orderBy('created_at', 'desc')->get();
        $user = User::latest('id')->first();
        return view('chats.chat', compact('messages', 'users', 'user'));
    }

    public function downloadFile($id)
    {
        $file = Message::findOrFail($id);

        $filePath = storage_path('app/chat_files/' . $file->file_name);

        return response()->download($filePath, $file->file_name);
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
        $users = User::whereNot('id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('chats.chat', compact('messages', 'user', 'users'));
    }

    public function store(Request $request)
    {
        $data['user_id'] = auth()->id();
        $data['sendler_user_id'] = $request->sendler_user_id;

        if ($request->hasFile('file_name')) {
            $request->validate([
                'message' => 'nullable|string',
                'file_name' => 'sometimes|file|max:102400',
            ]);
            if($request->message) {
                $data['message'] = $request->message;
            }
            else {
                $data['message'] = '';
            }
            $file = $request->file('file_name');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('chat_files', $fileName);

            $data['file_name'] = $fileName;
        }
        else {
            $request->validate([
                'message' => 'sometimes|string',
            ]);
            $data['message'] = $request->message;
            $data['file_name'] = '';
        }
        // Создание новой записи в базе данных
        $messages = Message::create($data);

        // Возвращение JSON-ответа
        return response()->json(['success' => 'Сообщение успешно отправлено!', 'message' => $messages]);
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
