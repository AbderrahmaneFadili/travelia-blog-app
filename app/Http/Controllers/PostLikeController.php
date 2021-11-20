<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{

    //get likes Count by postId
    public function likesCount($id)
    {
        $post = Post::find($id);

        $count = $post->likes()->count();

        return [
            'likes_count' => $count
        ];
    }

    //add like
    public function store(Request $request, $postId)
    {
        //get post by id
        $post = Post::find($postId);

        //add post like
        return  $post->likes()->create([
            'user_id' => $request->user()->id,
        ]);
    }

    //delete like
    public function destroy($likeId)
    {
        //get the post like
        $postLike = PostLike::find($likeId);

        //delete the post like
        $postLike->delete();

        return [
            'message' => 'like removed',
        ];
    }
}
