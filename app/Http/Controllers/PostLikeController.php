<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function store(Request $request, $postId)
    {
        $post = Post::find($postId);

        return  $post->likes()->create([
            'user_id' => $request->user()->id,
        ]);
    }

    public function destroy($likeId)
    {
        $postLike = PostLike::find($likeId);

        $postLike->delete();

        return [
            'message' => 'like removed',
        ];
    }
}
