<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;

class CourseAbort extends Model
{
    // caused_by
    const STUDENT_COMPLETE = 1;
    const CHANGE_TEACHER = 2;
    const TRANSFER = 3;
    const REFUND = 4;
    // course type
    const TYPE_TRIAL = 7;
    const TYPE_3_MONTHS = 1;
    const TYPE_6_MONTHS = 2;
    const TYPE_9_MONTHS = 3;
    const TYPE_1_YEAR = 4;
    const TYPE_1_5_YEAR = 5;
    const TYPE_2_YEAR = 6;

    protected $table = 'course_aborts';

    protected $fillable = [
        'created_by',
        'course_id',
        'course_type',
        'teacher_group_id',
        'caused_by',
        'continue',
        'reason_group',
        'reason_note',
        'promoter_type',
    ];

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
}
