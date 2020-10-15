<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;

class Review extends Model
{
    const RATE_CURRICULUM_CONTENT = 1;
    const RATE_TEACHING_METHOD = 2;
    const RATE_ATTITUDE = 3;
    const RATE_SATISFACTION = 4;
    const RATE_REFER_FRIEND = 5;
    // old system
    const RATE_NETWORK_QUALITY = 6;
    const RATE_USEFUL = 7;

    // type
    const REVIEW_COURSE_TEACHER = 1;
    const REVIEW_COURSE_STUDENT = 2;
    const REVIEW_COURSE_CARER = 3;
    const REVIEW_COURSE_TEST = 4;
    const REVIEW_COURSE_FEEDBACK = 5;
    const REVIEW_TEACHER_ONLY = 6;
    const REVIEW_SESSION_TEACHER = 7;
    const REVIEW_SESSION_STUDENT = 8;

    // status for a review (public or private)
    const STATUS_PUBLIC = 1;
    const STATUS_PRIVATE = 2;

    // evaluation loop
    const LOOP_KID = 15;
    const LOOP_WORK = 12;


    protected $table = 'reviews';

    protected $fillable = [
        'created_by',
        'reviewer_id',
        // 'rates', // [{"id": 1, "rated": "3", "max_rate": "5"}]
        'review',
        'avg_rate',
        'type',
        'status',
        'rates',
    ];

    public function getCountAfterSessionsAttribute()
    {
        $reviewId = $this->attributes['id'];

        $countAfterSession = \DB::table('courses_reviews')
            ->where('review_id', '=', $reviewId)
            ->first();

        if ($countAfterSession) {
            return $countAfterSession->count_after_sessions;
        }

        return null;
    }

    public function getRatesAttribute()
    {
        return empty($this->attributes['rates']) ? [] : json_decode($this->attributes['rates'], true);
    }

    public function setRatesAttribute($value)
    {
        $this->attributes['rates'] = json_encode(empty($value) ? [] : $value);
    }

    public function getHtmlReviewAttribute()
    {
        return nl2br($this->attributes['review']);
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'longTime', $this->attributes['updated_at']);
    }

    public function getFormattedCreatedAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'longTime', $this->attributes['created_at']);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_reviews', 'review_id', 'course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id', 'id');
    }

    public function replies()
    {
        return $this->belongsToMany(CommentThread::class, 'review_threads', 'review_id', 'thread_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teachers_reviews', 'review_id', 'teacher_id');
    }

    public function details()
    {
        return $this->hasMany(ReviewDetail::class, 'review_id', 'id');
    }
}
