<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;

class ClaimRequest extends Model
{
    const STATUS_OPEN = 1;
    const STATUS_CLOSE = 2;

    protected $table = 'claim_requests';

    protected $fillable = [
        'created_by',
        'cared_by',
        'request_id',
        'name',
        'age',
        'gender',
        'target_topic',
        'target_level',
        'target_time',
        'target_others',
        'result_type',
        'result_duration',
        'status',

        'old_id',
    ];

    public function getFormattedCreatedAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortTime', ' ', 'shortDate', $this->attributes['created_at']);
    }

    public function getGenderNameAttribute()
    {
        return transGender($this->attributes['gender']);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function carer()
    {
        return $this->belongsTo(User::class, 'cared_by', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_claim_requests', 'request_id', 'tag_id');
    }

    public function topics()
    {
        return $this->belongsToMany(LearningTopic::class, 'claim_requests_topics', 'request_id', 'topic_id');
    }

    public function teacherGroups()
    {
        return $this->belongsToMany(TeacherGroup::class, 'claim_teacher_groups', 'request_id', 'teacher_group_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'claim_responses', 'request_id', 'teacher_id')
            ->withPivot([
                'text',
                'status',
                'updated_at'
            ]);
    }

    public function responses()
    {
        return $this->hasMany(ClaimResponse::class, 'request_id', 'id');
    }

    public function learningRequest()
    {
        return $this->belongsTo(LearningRequest::class, 'request_id', 'id');
    }
}
