<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
class PostsController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::paginate($request->input('per_page', 20))
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
        return redirect()->route('admin.posts.index')->withSuccess("Мәлімет қосылды!");
    }
    
    public function edit(Post $post)
    {
        return Inertia::render('Admin/Posts/Edit', [
            'post' => $post,
            'imageUrl' => asset($post->image),
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

        if ($request->updateImage) {
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
        return redirect()->back()->withSuccess("Сәтті сақталды!");
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back()->withSuccess("Сәтті жойылды!");
    }
}
