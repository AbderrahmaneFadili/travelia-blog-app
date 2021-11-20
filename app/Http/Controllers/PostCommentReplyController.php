<?php

namespace App\Http\Controllers;

use App\Models\PostComment;
use App\Models\PostCommentReply;
use Illuminate\Http\Request;

class PostCommentReplyController extends Controller
{
    public function store(Request $request, $commentId)
    {
        $this->validate($request, [
            'body' => 'required|max:400'
        ]);

        $comment = PostComment::find($commentId);

        return $comment->replies()->create([
            "user_id" => $request->user()->id,
            'body' => $request->body,
        ]);
    }

    public function destroy($replyId)
    {
        $reply = PostCommentReply::find($replyId);

        $result = $reply->delete();

        return [
            "message" => $result > 0 ? "Reply deleted" : "Repply not deleted"
        ];
    }

    public function update(Request $request, $replyId)
    {
        $this->validate($request, [
            'body' => 'required|max:400'
        ]);

        $reply = PostCommentReply::find($replyId);

        $result =  $reply->update([
            'body' => $request->body,
        ]);

        return [
            'message' => $result > 0 ? "Reply Updated" : "Reply not updated"
        ];
    }

    public function repliesByComment($commentId)
    {
        $comment = PostComment::find($commentId);

        $replies = $comment->replies;

        return [
            'replies' => $replies
        ];
    }
}
