<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\UserPostBookmark;
use App\Models\Friend;
use App\Models\UserPostRelationship as ModelsUserPostRelationship;
use Illuminate\Http\Request;
use App\Http\Requests\profileSaveRequest;
use App\Models\FriendRequests;
use App\Services\FileService;

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
        if ($user->id == auth()->id()) {
            return view('user.edit', compact('user'));
        }
        return redirect()->route('user.index');
    }

    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $data = [];

        $oldAvatar = basename($user->image);
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $image_name = FileService::saveFile($image, "/avatars", $oldAvatar);
            $data['avatar'] = 'avatars/' . $image_name;
        }
        $data['password'] = Hash('sha1', $request['password']);
        $data['real_password'] = $request['password'];
        $data['fio'] = $request->surname . ' ' . $request->name . ' ' . $request->lastname;

        $user->update(array_merge($request->except(['avatar', 'password', 'real_password']), $data));

        return redirect('/');
    }

    public function bookmarks()
    {
        $user = auth()->guard('web')->user();
        // $bookmarkedPosts = User::with('bookmarks.post')->find($user->id);
        $bookmarkedPosts = User::with(['bookmarks.post' => function ($query) {
            $query->withCount('likes');
        }])->find($user->id);

        $bookmarkedPosts->bookmarks = $bookmarkedPosts->bookmarks->sortByDesc(function ($bookmark) {
            return $bookmark->post->created_at;
        });
        $likedFriends = Friend::where('user1_id', auth()->id())
            ->with('user2')
            ->get();
        $likedOthers = User::latest('id')
            ->get();
        return view('user.bookmarks', compact('bookmarkedPosts', 'likedFriends', 'likedOthers'));
    }

    public function profile($user_id)
    {
        $user = User::find($user_id);
        $posts = Post::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();

        $friendRequests = FriendRequests::where('user_id', auth()->id())
            ->where('is_waiting', 1)
            ->get();

        $me = auth()->guard('web')->user();
        $is_friend = Friend::where('user1_id', $me->id)
            ->where('user2_id', $user_id)
            ->exists();
        return view('user.profile', compact('user', 'posts', 'friendRequests', 'is_friend'));
    }

    public function deleteFriend(Request $request)
    {
        $friendId = $request->input('friend_id');
        $friendship = Friend::where('user1_id', auth()->id())
            ->where('user2_id', $friendId)
            ->orWhere(function ($query) use ($friendId) {
                $query->where('user1_id', $friendId)
                    ->where('user2_id', auth()->id());
            })
            ->delete();
        FriendRequests::where(function ($query) use ($friendId) {
            $query->where('user_id', auth()->id())
                ->where('receiver_user_id', $friendId);
        })->orWhere(function ($query) use ($friendId) {
            $query->where('user_id', $friendId)
                ->where('receiver_user_id', auth()->id());
        })->delete();

        return response()->json(['message' => 'Friend deleted succesfully!'], 200);
    }
}
