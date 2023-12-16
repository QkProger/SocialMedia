<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class FriendsController extends Controller
{
    public function messanger()
    {
        $friends = Friend::where('user1_id', auth()->id())
            ->with('user2')
            ->get();
        return view('chats.messanger', compact('friends'));
    }
}
