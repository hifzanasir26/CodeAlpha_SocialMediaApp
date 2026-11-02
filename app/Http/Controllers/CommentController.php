<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $postId,
            'comment' => $request->comment,
        ]);

        return redirect()->back();
    }
}
