<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherInterview extends Model
{
    const INTERVIEW_TYPE_NEWLY = 1;
    const INTERVIEW_TYPE_RESCHEDULE = 2;

    const INTERVIEW_NO_RESULT = 0;
    const INTERVIEW_PASSED = 1;
    const INTERVIEW_FAILED = 2;

    protected $table = 'teacher_interviews';

    protected $fillable = [
        'teacher_id',
        'interviewed_by',
        'interviewed_at',
        'has_result',
        'passed',
        'note',
        'type',
        'mailed',
        'mailed_at',
        'course_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'user_id');
    }

    public function interviewer()
    {
        return $this->belongsTo(User::class, 'interviewed_by', 'id');
    }
}
