<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
  public function like($postId)
{
    $like = Like::where('user_id', auth()->id())
                ->where('post_id', $postId)
                ->first();

    if ($like) {
        $like->delete(); // unlike
    } else {
        Like::create([
            'user_id' => auth()->id(),
            'post_id' => $postId,
        ]);
    }

    return redirect()->back();
}
}