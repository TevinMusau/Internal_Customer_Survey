<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment_by',
        'comment_about',
        'title',
        'comment',
        'date',
        'comment_type',
    ];

    public function commentor(){
        return $this->belongsTo(User::class);
    }

    public function commentee(){
        return $this->belongsTo(User::class);
    }
}
