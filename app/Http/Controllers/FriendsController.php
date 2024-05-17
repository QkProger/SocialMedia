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
        // $friends = Friend::where('user1_id', auth()->id())
        //     ->with('user2')
        //     ->get();

        $query = $request->input('query');

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
            // ->latest()->take(2)->get();
            ->latest()->get();

        return view('chats.messanger', compact('friends', 'otherUsers'));
    }

    // public function search(Request $request)
    // {
    //     $query = $request->input('query');

    //     $friends = Friend::where('user1_id', auth()->id())
    //         ->whereHas('user2', function ($innerQuery) use ($query) {
    //             $innerQuery->where('name', 'LIKE', "%$query%")
    //                 ->orWhere('surname', 'LIKE', "%$query%")
    //                 ->orWhere('nickname', 'LIKE', "%$query%");
    //         })
    //         ->with('user2')
    //         ->get();

    //     // Извлечение id друзей
    //     $friendIds = $friends->pluck('user2.id')->toArray();

    //     // Получение остальных пользователей, исключая друзей
    //     $otherUsers = User::where('id', '!=', auth()->id())
    //         ->where(function ($userQuery) use ($friendIds, $query) {
    //             $userQuery->whereNotIn('id', $friendIds)
    //                 ->orWhereNull('id');
    //         })
    //         ->where(function ($userQuery) use ($query) {
    //             $userQuery->where('name', 'LIKE', "%$query%")
    //                 ->orWhere('surname', 'LIKE', "%$query%")
    //                 ->orWhere('nickname', 'LIKE', "%$query%");
    //         })
    //         ->get();

    //     return view('chats.messanger', compact('friends', 'otherUsers'));
    // }
}
