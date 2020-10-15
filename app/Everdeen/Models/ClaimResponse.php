<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;

class ClaimResponse extends Model
{
    const STATUS_WAIT = 1;
    const STATUS_CHOSEN = 2;
    const STATUS_FAILED = 3;

    protected $table = 'claim_responses';

    protected $fillable = [
        'request_id',
        'teacher_id',
        'text',
        'status',
    ];

    public function getFormattedCreatedAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortTime', ' ', 'shortDate', $this->attributes['created_at']);
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortTime', ' ', 'shortDate', $this->attributes['updated_at']);
    }

    public function getHtmlTextAttribute()
    {
        return nl2br($this->attributes['text']);
    }

    public function request()
    {
        return $this->belongsTo(ClaimRequest::class, 'request_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'user_id');
    }
}
