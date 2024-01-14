<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    protected $table = 'posts';
    protected $guarded = ['id'];

    use HasFactory, SoftDeletes;

    public function authorPost()
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

    public function postComment()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
}
