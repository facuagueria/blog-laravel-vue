<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostEditResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function index()
    {
        return PostResource::collection(Post::latest()->get());
    }

    public function show(Post $post)
    {
        return new PostEditResource($post);
    }

    public function store()
    {
        $post = Post::create([
            'title' => 'Untitled Post'
        ]);

        return new PostResource($post);
    }

    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'title' => 'required',
            'teaser' => 'nullable',
            'body' => 'nullable',
            'slug' => 'required|string|unique:posts,slug,' . $post->id,
            'published' => 'boolean'
        ]);

        $post->update($request->only('title', 'teaser', 'body', 'published', 'slug'));
    }
}
