<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'success',
            'data' => Post::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $post = new Post([
            'title' => $request->title,
            'content' => $request->content,
            'photo' => $request->photo ? $request->file('photo')->store('posts', 'public') : null,
        ]);

        $post->save();

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post,
            'photo_url' => asset('storage/' . $post->photo)
        ], 201);
    }

    public function show(Post $post)
    {
        return response()->json([
            'message' => 'success',
            'data' => $post
        ]);
    }

    public function update(Request $request, Post $post)
    {
        Gate::authorize('modify', $post);
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $post->title = $request->title;
        $post->content = $request->content;
        if ($request->hasFile('photo')) {
            $post->photo = $request->file('photo')->store('posts', 'public');
        }

        $post->save();

        return response()->json([
            'message' => 'Post updated successfully',
            'post' => $post,
            'photo_url' => asset('storage/' . $post->photo)
        ]);
    }

    public function destroy(Post $post)
    {
        Gate::authorize('modify', $post);
        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
    }
}
