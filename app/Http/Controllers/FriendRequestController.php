<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\FriendRequests;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class FriendRequestController extends Controller
{
    public function usersList(Request $request)
    {
        $query = $request->input('query');
        // Получение списка друзей, удовлетворяющих запросу
        $friends = Friend::where('user1_id', auth()->id())
            ->whereHas('user2', function ($innerQuery) use ($query) {
                $innerQuery->where('name', 'LIKE', "%$query%")
                    ->orWhere('surname', 'LIKE', "%$query%")
                    ->orWhere('nickname', 'LIKE', "%$query%");
            })
            ->with('user2')
            ->get();

        // Извлечение id друзей
        $friendIds = $friends->pluck('user2.id')->toArray();

        // Получение остальных пользователей, исключая друзей
        $otherUsers = User::where('id', '!=', auth()->id())
            ->where(function ($userQuery) use ($friendIds, $query) {
                $userQuery->whereNotIn('id', $friendIds)
                    ->orWhereNull('id');
            })
            ->where(function ($userQuery) use ($query) {
                $userQuery->where('name', 'LIKE', "%$query%")
                    ->orWhere('surname', 'LIKE', "%$query%")
                    ->orWhere('nickname', 'LIKE', "%$query%");
            })
            ->get();

        $friendRequests = FriendRequests::where('user_id', auth()->id())
            ->where('is_waiting', 1)
            ->get();

        return view('user.List', compact('friends', 'otherUsers', 'friendRequests'));
    }

    public function store(Request $request)
    {
        $data['user_id'] = auth()->id();
        $data['receiver_user_id'] = $request->receiver_user_id;
        // Создание новой записи в базе данных
        $userRequests = FriendRequests::create($data);

        // Возвращение JSON-ответа
        return response()->json(['success' => 'Сообщение успешно отправлено!', 'userRequests' => $userRequests]);
    }

    public function accept_update($id)
    {
        $user = auth()->user();
        FriendRequests::where('user_id', $id)->where('receiver_user_id', $user->id)->update(
            [
                'is_accepted' => true,
                'is_waiting' => false
            ]
        );
        $data['user1_id'] = auth()->id();
        $data['user2_id'] = $id;
        Friend::create($data);
        $data['user1_id'] = $id;
        $data['user2_id'] = auth()->id();
        Friend::create($data);
        return back();
    }

    public function decline_update($id)
    {
        $user = auth()->user();
        FriendRequests::where('user_id', $id)->where('receiver_user_id', $user->id)->update(
            [
                'is_declined' => true,
                'is_waiting' => false
            ]
        );
        return back();
    }
}
