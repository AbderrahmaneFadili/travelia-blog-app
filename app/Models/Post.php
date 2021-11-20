<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'image_path',
        'category_id',
        'user_id'
    ];

    //One post can have multiple likes
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    //One post can have multiple comments
    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }
}
