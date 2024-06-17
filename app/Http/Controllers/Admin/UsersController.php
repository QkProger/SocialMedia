<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\Gruppa;
use App\Models\GruppaMessage;
use App\Models\GruppaUser;
use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use App\Models\UserPostBookmark;
use App\Models\UserPostRelationship;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::paginate($request->input('per_page', 20))
            ->appends($request->except('page'));

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Users/Create');
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'lastname' => $request['lastname'],
            'surname' => $request['surname'],
            'fio' => $request->surname . ' ' . $request->name . ' ' . $request->lastname,
            'nickname' => $request['nickname'],
            'email' => $request['email'],
            'iin' => $request['iin'],
            'password' => Hash('sha1', $request['real_password']),
            'real_password' => $request['real_password'],
            'admin' => $request['admin'],
        ]);
        GruppaUser::create([
            'gruppa_id' => Gruppa::first()->id,
            'user_id' => $user->id,
            'is_admin' => $user->admin,
        ]);
        return redirect()->route('admin.users.index')->withSuccess("Мәлімет қосылды!");
    }

    public function edit(User $user)
    {
        $user->admin = $user->admin ? true : false;
        return Inertia::render('Admin/Users/Edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $user->update([
            'name' => $request['name'],
            'lastname' => $request['lastname'],
            'surname' => $request['surname'],
            'fio' => $request->surname . ' ' . $request->name . ' ' . $request->lastname,
            'nickname' => $request['nickname'],
            'email' => $request['email'],
            'iin' => $request['iin'],
            'password' => Hash('sha1', $request['real_password']),
            'real_password' => $request['real_password'],
            'admin' => $request['admin'] ? 1 : 0,
        ]);
        GruppaUser::where('gruppa_id', Gruppa::first()->id)->where('user_id', $user->id)->delete();
        GruppaUser::create([
            'gruppa_id' => Gruppa::first()->id,
            'user_id' => $user->id,
            'is_admin' => $user->admin,
        ]);
        return redirect()->route('admin.users.index')->withSuccess("Сәтті сақталды!");
    }

    public function destroy(User $user)
    {
        $user->delete();
        Post::where('user_id', $user->id)->delete();
        Friend::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
            ->delete();
        GruppaUser::where('user_id', $user->id)->delete();
        GruppaMessage::where('user_id', $user->id)->delete();
        Message::where('user_id', $user->id)
            ->orWhere('sendler_user_id', $user->id)
            ->delete();
        UserPostRelationship::where('user_id', $user->id)->delete();
        UserPostBookmark::where('user_id', $user->id)->delete();
        return redirect()->back()->withSuccess("Сәтті жойылды!");
    }
}
