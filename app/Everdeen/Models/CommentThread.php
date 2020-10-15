<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class CommentThread extends Model
{
    protected $table = 'comment_threads';

    protected $fillable = [
        'parent_id',
        'user_id',
        'content',
    ];

    public function reviews()
    {
        return $this->belongsToMany(Review::class, 'review_threads', 'thread_id', 'review_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
