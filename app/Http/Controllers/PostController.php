<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\UserPostRelationship;
use App\Models\Friend;
use App\Models\User;
use App\Models\UserPostBookmark;
use App\Services\FileService;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('likes.user')->withCount('likes')->orderBy('id', 'desc')->get();
        $likedFriends = Friend::where('user1_id', auth()->id())
            ->with('user2')
            ->get();
        $likedOthers = User::orderBy('id', 'desc')
            ->get();
        return view('post.index', compact('posts', 'likedFriends', 'likedOthers'));
    }


    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'title' => 'string',
            'content' => '',
            'description' => 'string',
            'image' => 'image',
        ]);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $post_image = $request->file('image');
            $file_name = FileService::saveFile($post_image, "/posts");
            $data['image'] = 'posts/' . $file_name;
        }
        Post::create($data);
        return redirect()->route('user.index');
    }

    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        if ($post->user_id == auth()->id() || auth()->user()->admin) {
            return view('post.edit', compact('post'));
        }
        return redirect()->route('user.index');
    }

    public function update(Request $request, Post $post)
    {
        $data = request()->validate([
            'title' => '',
            'content' => '',
            'description' => '',
            'image' => 'image',
        ]);

        $oldPostImage = basename($post->image);
        if ($request->hasFile('image')) {
            $post_image = $request->file('image');
            $file_name = FileService::saveFile($post_image, "/posts", $oldPostImage);
            $data['image'] = 'posts/' . $file_name;
        }
        $post->update($data);
        return redirect()->route('user.index');
    }

    public function destroy(Post $post)
    {
        UserPostBookmark::where('post_id', $post->id)->delete();
        UserPostRelationship::where('post_id', $post->id)->delete();
        Comments::where('post_id', $post->id)->delete();
        $post->delete();
        return redirect()->route('post.index');
    }
}
