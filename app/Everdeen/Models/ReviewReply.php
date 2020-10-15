<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewReply extends Model
{
    protected $table = 'review_replies';

    protected $fillable = [
        'review_id',
        'created_by',
        'reply',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
