<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\FriendRequests;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class FriendsController extends Controller
{
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
            ->where(function ($userQuery) use ($friendIds, $query) {
                $userQuery->whereNotIn('id', $friendIds);
            })
            ->orderBy('id', 'desc')->get();

        return view('chats.messanger', compact('friends', 'otherUsers'));
    }
}
