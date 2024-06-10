<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\FileService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
class PostsController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('user')->paginate($request->input('per_page', 20))
        ->appends($request->except('page'));;
        
        return Inertia::render('Admin/Posts/Index', [
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Posts/Create');
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'title' => 'string',
            'content' => 'nullable|string',
            'description' => 'string',
            'image' => 'image',
            'video' => 'nullable|string',
        ]);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $post_image = $request->file('image');
            $file_name = FileService::saveFile($post_image, "/posts");
            $data['image'] = 'posts/' . $file_name;
        }

        Post::create($data);
        return redirect()->route('admin.posts.index')->withSuccess("Мәлімет қосылды!");
    }
    
    public function edit(Post $post)
    {
        return Inertia::render('Admin/Posts/Edit', [
            'post' => $post,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $post = Post::FindOrFail($id);
        $data = request()->validate([
            'title' => '',
            'content' => '',
            'description' => '',
            'image' => '',
            'video' => '',
        ]);

        $oldPostImage = basename($post->image);
        if ($request->hasFile('image')) {
            $post_image = $request->file('image');
            $file_name = FileService::saveFile($post_image, "/posts", $oldPostImage);
            $data['image'] = 'posts/' . $file_name;
        }
        $post->update($data);
        return redirect()->back()->withSuccess("Сәтті сақталды!");
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back()->withSuccess("Сәтті жойылды!");
    }
}
