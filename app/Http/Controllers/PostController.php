<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * get all posts
     */
    public function index(Request $request)
    {
        $posts = Post::latest()->paginate($request->perPage);

        return response()->json([
            'posts' => $posts
        ], 200);
    }

    /**
     * Create a post
     */
    public function store(Request $request)
    {

        //validate post data
        $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required|max:500',
            'image_path' => 'required',
            'category' => 'required',
            'user_id' => 'required'
        ]);

        //create the post & return as json
        return $request->user()->posts()->create([
            'title' => $request->title,
            'body' => $request->body,
            'image_path' => $request->image_path,
            'category_id' => $request->category,
            'user_id' => $request->user()->id,
        ]);
    }

    /**
     * Update a post
     */
    public function update(Request $request)
    {
        //find post by id
        $post = Post::find($request->postId);

        //validate post data
        $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required|max:500',
            'image_path' => 'required',
            'category' => 'required',
        ]);

        //update post
        $result =  $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'image_path' => $request->image_path,
            'category' => $request->category,
        ]);

        return [
            "message" => $result > 0 ? "Post Updated" : "Post Not Updated",
        ];
    }

    /**
     *  Delete post
     */
    public function destroy(Request $request)
    {
        $post = Post::find($request->postId);
        $result = $post->delete();
        return [
            'message' => $result > 0 ? 'Post Deleted' : 'Post Not Deleted'
        ];
    }

    /**
     * Search posts with pagination
     */
    public function search(Request $request)
    {

        $posts = Post::where('title', 'like', "%" . $request->search . "%")->orWhere('title', 'like', "%" . $request->search . "%")->paginate(2);

        return $posts;
    }
}
