<?php
/**
 * Created by: Thang.Nguyen <thang.nguyen@antoree.com>
 * Created on: 2017-06-13
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;

class Issue extends Model
{
    const STATUS_NEWLY = 0;
    const STATUS_RECEIVED = 1;
    const STATUS_HANDLING = 2;
    const STATUS_HANDLED = 3;
    const STATUS_NOT_HANDLE = 4;
    const STATUS_CLOSED = 5;
    const STATUS_REOPEN = 6;

    const SOURCE_STUDENT = 1;
    const SOURCE_TEACHER = 2;
    const SOURCE_ANTOREE = 3;

    const TYPE_NORMAL = 1;
    const TYPE_COURSE = 2;
    const TYPE_COURSE_REVIEW = 3;

    const REFER_COURSE = 'courses';

    protected $table = 'issues';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'handler_id',
        'content',
        'attachments',
        'source',
        'status',
        'type',
        'refer_table',
        'refer_id',
        'count_open',
        'opened_at',
        'closed_at',
        'note',
    ];

    public function getFormattedOpenedAtAttribute()
    {
        return $this->attributes['opened_at'] ? DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'longTime', $this->attributes['opened_at']) : null;
    }

    public function getFormattedClosedAtAttribute()
    {
        return $this->attributes['closed_at'] ? DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'longTime', $this->attributes['closed_at']) : null;
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }

    public function referCourse()
    {
        return $this->belongsTo(Course::class, 'refer_id', 'id');
    }
}
