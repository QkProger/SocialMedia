<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\UserPostRelationship;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('likes.user')->withCount('likes')->orderBy('created_at', 'desc')->get();
        $likedFriends = Friend::where('user1_id', auth()->id())
            ->with('user2')
            ->get();
        $likedOthers = User::latest()
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
            'content' => 'string',
            'description' => 'string',
            'image' => 'image',
            'video' => 'string',
        ]);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            // Получаем загруженный файл
            $image = $request->file('image');

            // Генерируем уникальное имя для файла
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Сохраняем файл на сервер
            $image->storeAs('public/images', $imageName);

            // Сохраняем путь к файлу в базу данных
            $data['image'] = 'storage/images/' . $imageName;
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
        return view('post.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = request()->validate([
            'title' => '',
            'content' => '',
            'description' => '',
            'image' => 'image',
            'video' => '',
        ]);

        if ($request->hasFile('image')) {
            // Получите старый путь к изображению
            $oldImagePath = asset($post->image);

            // Если старый путь существует, удалите старое изображение
            if ($oldImagePath && Storage::exists($oldImagePath)) {
                Storage::delete($oldImagePath);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $data['image'] = 'storage/images/' . $imageName;
        }
        $post->update($data);
        return redirect()->route('user.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('pages.index');
    }
}
