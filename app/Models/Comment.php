<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    
    protected $table = 'comments';
    
    protected $guarded = ['id'];
    
    use HasFactory, SoftDeletes;

    public function userComment()
    {
       return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
