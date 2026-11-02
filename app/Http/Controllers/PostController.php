<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $posts = Post::with('user', 'likes', 'comments.user')

            ->when($search, function ($query) use ($search) {

                $query->where('content', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {

                        $q->where('name', 'like', "%{$search}%");
                    });
            })

            ->latest()
            ->get();

        return view('dashboard', compact('posts'));
    }

    public function store(Request $request)
    {
        $imageName = null;

        if ($request->hasFile('image')) {

            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('images'), $imageName);
        }

        Post::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'image' => $imageName,
        ]);

        return redirect()->back();
    }

    public function destroy(Post $post)
    {
        // only owner can delete
        if ($post->user_id != auth()->id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->back();
    }
    public function update(Request $request, Post $post)
    {
        if ($post->user_id != auth()->id()) {
            abort(403);
        }

        $data = [
            'content' => $request->content,
        ];

        // Image Update
        if ($request->hasFile('image')) {

            $image = time() . '.' .
                $request->image->extension();

            $request->image->move(
                public_path('images'),
                $image
            );

            $data['image'] = $image;
        }

        $post->update($data);

        return redirect()->route('dashboard');
    }
    public function edit(Post $post)
    {
        if ($post->user_id != auth()->id()) {
            abort(403);
        }

        return view('edit-post', compact('post'));
    }
}
