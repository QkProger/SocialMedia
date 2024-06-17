<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comments;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommentController extends Controller
{
    public function index(Request $request, $post_id)
    {
        $comments = Comments::with(['user', 'mainComment'])->where('post_id', $post_id)->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));;

        return Inertia::render('Admin/Posts/Comments', [
            'comments' => $comments,
        ]);
    }

    public function destroy(Comments $comment)
    {
        Comments::where('parent_id', $comment->id)->delete();
        $comment->delete();
        return redirect()->back()->withSuccess("Сәтті жойылды!");
    }
}
