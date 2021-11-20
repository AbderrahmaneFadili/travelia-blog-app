<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $this->validate($request, [
            'body' => 'required|max:500'
        ]);

        $post = Post::find($postId);

        return $post->comments()->create([
            "user_id" => $request->user()->id,
            'body' => $request->body,
        ]);
    }

    public function update(Request $request, $commentId)
    {
        //validate comment
        $this->validate($request, [
            'body' => 'required|max:500'
        ]);

        //get the comment
        $comment = PostComment::find($commentId);

        //update comment
        $result = $comment->update([
            'body' => $request->body,
        ]);

        return [
            'message' => $result > 0 ? "Comment Updated" : "Comment Not Updated"
        ];
    }

    public function destroy($commentId)
    {
        //get the comment
        $comment = PostComment::find($commentId);

        //delete the comment
        $result = $comment->delete();

        return [
            'message' => $result > 0 ? "Comment Deleted" : "Comment Not deleted"
        ];
    }

    //get all post comments
    public function allPostComments($postId)
    {
        $post = Post::find($postId);

        $comments = $post->comments;

        return [
            'comments' => $comments
        ];
    }
}
