<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * get all posts
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * Create a post
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required|max:500',
            'image_path' => 'required',
            'category' => 'required',
        ]);

        return Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'image_path' => $request->image_path,
            'category_id' => $request->category,
            'user_id' => $request->user_id
        ]);
    }
}
