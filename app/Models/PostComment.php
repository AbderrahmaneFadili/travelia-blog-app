<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "post_id",
        'body',
    ];

    //one comment can have multiple replies
    public function replies()
    {
        return $this->hasMany(PostCommentReply::class);
    }
}
