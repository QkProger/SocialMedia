<?php

namespace App\Http\Controllers;

use App\Models\UserPostBookmark;
use App\Models\UserPostRelationship as ModelsUserPostRelationship;
use Illuminate\Http\Request;

class UserPostRelationshipController extends Controller
{
    public function like_send(Request $request)
    {
        $user_id = auth()->id();
        $post_id = $request->post_id;

        // Проверяем, существует ли запись о лайке
        $existingRelationship = ModelsUserPostRelationship::where('post_id', $post_id)
            ->where('user_id', $user_id)
            ->first();

        // Если запись уже существует, то удаляем лайк, иначе создаем новую запись
        if ($existingRelationship) {
            $existingRelationship->delete();
            $isLiked = false;
        } else {
            ModelsUserPostRelationship::create(['post_id' => $post_id, 'user_id' => $user_id]);
            $isLiked = true;
        }
        return response()->json(['success' => 'Операция успешна!', 'isLiked' => $isLiked]);
    }


    public function post_save(Request $request)
    {
        $user_id = auth()->id();
        $post_id = $request->post_id;


        $existingRelationship = UserPostBookmark::where('post_id', $post_id)
            ->where('user_id', $user_id)
            ->first();

        if ($existingRelationship) {
            $existingRelationship->delete();
            $isSaved = false;
        } else {
            UserPostBookmark::create(['post_id' => $post_id, 'user_id' => $user_id]);   
            $isSaved = true;
        }

        return response()->json(['success' => 'Операция успешна!', 'isSaved' => $isSaved]);
    }
}
