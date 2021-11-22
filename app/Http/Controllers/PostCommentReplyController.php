<?php

namespace App\Http\Controllers;

use App\Models\PostComment;
use App\Models\PostCommentReply;
use Illuminate\Http\Request;

class PostCommentReplyController extends Controller
{
    /**
     * Add Post Comment Reply
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|max:400'
        ]);

        $comment = PostComment::find($request->commentId);

        return $comment->replies()->create([
            "user_id" => $request->user()->id,
            'body' => $request->body,
        ]);
    }

    /**
     * Delete Post Comment Reply
     */
    public function destroy(Request $request)
    {

        $reply = PostCommentReply::find($request->replyId);

        $result = $reply->delete();

        return [
            "message" => $result > 0 ? "Reply deleted" : "Repply not deleted"
        ];
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|max:400'
        ]);

        $reply = PostCommentReply::find($request->replyId);

        $result =  $reply->update([
            'body' => $request->body,
        ]);

        return [
            'message' => $result > 0 ? "Reply Updated" : "Reply not updated"
        ];
    }

    public function repliesByComment(Request $request)
    {
        $comment = PostComment::find($request->commentId);

        $replies = $comment->replies;

        return [
            'replies' => $replies
        ];
    }
}
