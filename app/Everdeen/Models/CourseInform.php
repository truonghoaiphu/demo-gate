<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;

class CourseInform extends Model
{
    // inform type
    const TYPE_REPORT_LATE = 1;
    const TYPE_REQUEST_ABSENCE = 2;
    const TYPE_REPORT_SUSPEND = 3;
    const COURSE_REQUEST_ABSENCE = 4;
    const COURSE_REQUEST_CHANGE_TEACHER_REJECT = 5;
    const COURSE_REQUEST_SUSPEND = 6;
    const COURSE_REQUEST_CHANGE_SCHEDULE = 7;
    const COURSE_REQUEST_OTHER = 8;

    // detail for an inform type
    const LATE_TYPE_5_15 = 1; // 5 - 15 minutes (old system)
    const LATE_TYPE_15_30 = 2; // 15 - 30 minutes (old system)
    const LATE_TYPE_QUIT = 3; // off (old system)
    const LATE_TYPE_LT30 = 4; // less than 30 minutes
    const LATE_TYPE_GTE30 = 5; // over 30 minutes

    const LATE_STATUS_OPEN = 1;
    const LATE_STATUS_CLOSE = 2;
    const LATE_STATUS_CONFIRM = 3;

    const SUSPEND_STATUS_OPEN = 1;
    const SUSPEND_STATUS_CLOSE = 2;
    const SUSPEND_STATUS_CONFIRM = 3;

    const STATUS_OPEN = 1;
    const STATUS_CLOSE = 2;
    const STATUS_CONFIRM = 3;

    const LATE_PENALTIES = [
        1 => 0.5,
        2 => 1,
        3 => 2,
        4 => 0.5,
        5 => 1,
    ];

    // suspend request reason type
    const SUSPEND_INTERNET_ISSUE = 1;
    const SUSPEND_SKYPE_ISSUE = 2;
    const SUSPEND_URGENT_LEAVE = 3;
    const SUSPEND_OTHER = 4;

    protected $table = 'course_informs';

    protected $fillable = [
        'course_id',
        'session_id',
        'created_by',
        'meta',
        'type',
    ];

    // for report late meta: {"late_type": 1, "penalty_duration": 1, "status": 3}
    // for absence request meta: {"reason": "absence reason"}
    // for suspend request meta: {"type": "suspend type", "reason": "suspend reason"} 
    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = json_encode(empty($value) ? [] : $value);
    }

    public function getMetaAttribute()
    {
        if (empty($this->attributes['meta'])) {
            return [];
        }

        $meta = json_decode($this->attributes['meta'], true);

        return $meta === false ? [] : $meta;
    }

    public function getFormattedCreatedAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'longTime', $this->attributes['created_at']);
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'longTime', $this->attributes['updated_at']);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function creater()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function session()
    {
        return $this->belongsTo(CourseSession::class, 'session_id', 'id');
    }
}
