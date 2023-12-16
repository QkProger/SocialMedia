<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\UserPostBookmark;
use App\Models\Friend;
use App\Models\UserPostRelationship as ModelsUserPostRelationship;
use Illuminate\Http\Request;
use App\Http\Requests\profileSaveRequest;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->guard('web')->user();
        $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('user.index', compact('user', 'posts'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $user_id)
    {
        // Инициализация массива $data
        $data = [];

        if ($request->hasFile('avatar')) {
            // Если пользователь загружает новое изображение, обработайте его и обновите запись
            $image = $request->file('avatar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $data['avatar'] = 'storage/images/' . $imageName;
        }

        // Обновление записи пользователя
        User::findOrFail($user_id)->update(array_merge($request->except('avatar'), $data));

        return redirect('/');
    }

    public function bookmarks()
    {
        $user = auth()->guard('web')->user();
        $bookmarkedPosts = User::with('bookmarks.post')->find($user->id);
        $bookmarkedPosts->bookmarks = $bookmarkedPosts->bookmarks->sortByDesc(function ($bookmark) {
            return $bookmark->post->created_at;
        });
        $likedFriends = Friend::where('user1_id', auth()->id())
            ->with('user2')
            ->get();
        $likedOthers = User::latest()
            ->get();
        return view('user.bookmarks', compact('bookmarkedPosts', 'likedFriends', 'likedOthers'));
    }
}
