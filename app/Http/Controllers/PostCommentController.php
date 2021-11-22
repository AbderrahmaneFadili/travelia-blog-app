<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    /**
     * Add Post Comment method
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|max:500'
        ]);

        $post = Post::find($request->postId);

        return $post->comments()->create([
            "user_id" => $request->user()->id,
            'body' => $request->body,
        ]);
    }

    /**
     * Update Post Comment method
     */
    public function update(Request $request)
    {
        //validate comment
        $this->validate($request, [
            'body' => 'required|max:500'
        ]);

        //get the comment
        $comment = PostComment::find($request->commentId);

        //update comment
        $result = $comment->update([
            'body' => $request->body,
        ]);

        return [
            'message' => $result > 0 ? "Comment Updated" : "Comment Not Updated"
        ];
    }

    public function destroy(Request $request)
    {
        //get the comment
        $comment = PostComment::find($request->commentId);

        //delete the comment
        $result = $comment->delete();

        return [
            'message' => $result > 0 ? "Comment Deleted" : "Comment Not deleted"
        ];
    }

    //get all post comments
    public function allPostComments(Request $request)
    {
        $post = Post::find($request->postId);

        $comments = $post->comments;

        return [
            'comments' => $comments
        ];
    }
}
