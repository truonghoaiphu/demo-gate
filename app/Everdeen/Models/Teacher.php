<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Teacher extends Model
{
    use SoftDeletes;

    const TEACHING_STATUS_NOT_VERIFIED = 0;
    const TEACHING_STATUS_NOT_TEACHING = 1;
    const TEACHING_STATUS_TEACHING = 2;
    const TEACHING_STATUS_OFF_FOR_TIME = 3;
    const TEACHING_STATUS_OFF = 4;

    const COURSE_STATUS_AVAILABLE = 1;
    const COURSE_STATUS_NOT_AVAILABLE = 2;
    const COURSE_STATUS_FULL = 3;

    const STATUS_NEWLY = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;
    const STATUS_PUBLISHED = 3;
    const STATUS_UNPUBLISHED = 4;

    // status transform
    const STATUS_TRANSFORM_TO = [
        0 => [1, 2],
        1 => [2, 3],
        2 => [1],
        3 => [2, 4],
        4 => [2, 3],
    ];

    const PASS_PROFILE_SETTING_UP = 1;
    const PASS_PROFILE_COMPLETE = 2;
    const PASS_PROFILE_QUIT = 3;

    const PASS_ENTRANCE_TEST_NOT_JOIN = 0;
    const PASS_ENTRANCE_TEST_DOING = 1;
    const PASS_ENTRANCE_TEST_PASSED = 2;
    const PASS_ENTRANCE_TEST_FAIL = 3;
    const PASS_ENTRANCE_TEST_REDO = 4;

    const PASS_INTERVIEW_NOT_JOIN = 0;
    const PASS_INTERVIEW_SCHEDULED = 1;
    const PASS_INTERVIEW_INTERVIEWED = 2;
    const PASS_INTERVIEW_PASSED = 3;
    const PASS_INTERVIEW_FAIL = 4;
    const PASS_INTERVIEW_REQUEST = 5;
    const PASS_INTERVIEW_SCHEDULING = 6;
    const PASS_INTERVIEW_RESCHEDULED = 7;

    const PASS_TRAINING_NOT_JOIN = 0;
    const PASS_TRAINING_DOING = 1;
    const PASS_TRAINING_PASSED = 2;

    const SETUP_STEP_1 = 1;
    const SETUP_STEP_2 = 2;
    const SETUP_STEP_3 = 3;
    const SETUP_STEP_4 = 4;

    const LOCK_FAIL_DAYS = 30;

    protected $table = 'teachers';

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'created_by',
        'approved_by',
        'approved_at',
        'text_jobs',
        'text_certificates',
        'experience_duration',
        'experience_duration_unit',
        'experience',
        'about_me',
        'meta', // voice, video
        'payment_info',
        'methodology',//{"Teaching Method": "Content...", "Teaching Kid": "Content..."}
        'course_status',
        'teaching_status',
        'status',
        'old_id',
        'note',
        'cared_by',
        'tag_line',
        'pass_profile',
        'pass_entrance_test',
        'pass_interview',
        'pass_training',
    ];

    protected $dates = ['deleted_at'];

    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = json_encode(empty($value) ? [] : $value);
    }

    public function getFormattedExperienceDurationAttribute()
    {
        if (empty($this->attributes['experience_duration'])) return '';

        $value = floatval($this->attributes['experience_duration']);
        $intValue = intval($value);
        if ($intValue - $value != 0) {
            return $value . ' ' . trans_choice('label.' . _k('experience_duration_units')[$this->attributes['experience_duration_unit'] - 1], $value);
        }
        return $intValue . ' ' . trans_choice('label.' . _k('experience_duration_units')[$this->attributes['experience_duration_unit'] - 1], $value);
    }

    public function getMetaAttribute()
    {
        if (empty($this->attributes['meta'])) {
            return [];
        }

        $meta = json_decode($this->attributes['meta'], true);

        return $meta === false ? [] : $meta;
    }

    public function getPaymentInformationAttribute()
    {
        if (empty($this->attributes['payment_info'])) {
            return [];
        }

        $paymentInfo = json_decode($this->attributes['payment_info'], true);

        return $paymentInfo === false ? [] : $paymentInfo;
    }

    public function setPaymentInformationAttribute($value)
    {
        $this->attributes['payment_info'] = json_encode(empty($value) ? [] : $value);
    }

    public function getVoiceAttribute()
    {
        $meta = $this->meta;
        return empty($meta['voice']) ? null : $meta['voice'];
    }

    public function getTeachingStatusNameAttribute()
    {
        return empty($this->attributes['teaching_status']) ?
            '' : transTeachingStatus($this->attributes['teaching_status']);
    }

    public function getCourseStatusNameAttribute()
    {
        return empty($this->attributes['course_status']) ?
            '' : transCourseStatus($this->attributes['course_status']);
    }

    public function getMethodologyAttribute()
    {
        if (empty($this->attributes['methodology'])) return [];
        $methodology = json_decode($this->attributes['methodology'], true);
        return $methodology !== false ? $methodology : [];
    }

    public function getTopicSalaryRatesAttribute()
    {
        $prefix = DB::getTablePrefix();
        return $this->salaryRates()
            ->with(['topic', 'topic.translations'])
            ->whereNotNull('teacher_salary_rates.topic_id')
            ->join(DB::raw('(select topic_id, max(changed_at) as max_changed_at from ' . $prefix . 'teacher_salary_rates'
                . ' where topic_id is not null and teacher_id = ' . $this->user_id
                . ' group by topic_id) as tmp'), function ($join) {
                $join->on(DB::raw('tmp.topic_id'), '=', 'teacher_salary_rates.topic_id')
                    ->where('teacher_salary_rates.changed_at', '=', DB::raw('tmp.max_changed_at'));
            })
            ->get();
    }

    public function userProfile()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function carer()
    {
        return $this->belongsTo(User::class, 'cared_by', 'id');
    }

    public function teachingTargetTopics()
    {
        return $this->belongsToMany(LearningTopic::class, 'teacher_target_topics', 'user_id', 'topic_id');
    }

    public function availableTimes()
    {
        return $this->hasMany(TeacherAvailableTime::class, 'user_id', 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_teachers', 'user_id', 'tag_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id', 'user_id');
    }

    public function topics()
    {
        return $this->belongsToMany(LearningTopic::class, 'teacher_target_topics', 'user_id', 'topic_id');
    }

    public function salaryRates()
    {
        return $this->hasMany(TeacherSalaryRate::class, 'teacher_id', 'user_id');
    }

    // teacher reviews
    public function reviews()
    {
        return $this->belongsToMany(Review::class, 'teachers_reviews', 'teacher_id', 'review_id');
    }


    public function getNumberStudentAttribute()
    {
        return $this->courses->groupBy('student_id')->count();
    }

    public function trainings()
    {
        return $this->belongsToMany(TeacherTraining::class, 'teacher_trained', 'teacher_id', 'training_id');
    }

    public function interviews()
    {
        return $this->hasMany(TeacherInterview::class, 'teacher_id', 'user_id')->orderBy('created_at', 'DESC');
    }

    public function customInformations()
    {
        return $this->hasMany(TeacherCustomInformation::class, 'teacher_id', 'user_id')->orderBy('order', 'ASC');
    }
}
