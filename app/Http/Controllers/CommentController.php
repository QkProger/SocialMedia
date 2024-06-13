<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $data = [
            'post_id' => $request->post_id,
            'content' => $request->content,
            'parent_id' => $request->parent_id ? $request->parent_id : null,
            'user_id' => auth()->id(),
        ];
        Comments::create($data);
        return redirect()->back();
    }
}
