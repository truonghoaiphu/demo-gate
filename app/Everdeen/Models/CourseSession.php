<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Katniss\Everdeen\Notifications\SessionChangeDatetimeNotification;
use Katniss\Everdeen\Notifications\SessionConfirmNotification;
use Katniss\Everdeen\Utils\DateTimeHelper;

class CourseSession extends Model
{
    use Notifiable;

    const TYPE_NORMAL = 1;
    const TYPE_MAKEUP = 2;
    const TYPE_PENALTY = 3;
    const TYPE_TEST = 4;
    const TYPE_BONUS = 5;
    const TYPE_COMPENSATION = 6;
    // const

    const STATUS_NEWLY = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_SUSPENDED = 3;
    const STATUS_PENALTY = 4;
    const STATUS_CANCELLED = 5;
    const STATUS_SUSPENDED_PENALTY = 6;
    const STATUS_NOT_HAPPENED = 7;

    protected $table = 'course_sessions';

    protected $fillable = [
        'course_id',
        'refer_curriculum_id',
        'occurred_at',
        'original_time',
        'occurred_week',
        'duration',
        'title',
        'content',
        'links',// [{"title":"title_1", url": "url_1"}]
        'attachments', //[{"name":"file1_name","type":"file1_type","url":"file1_url"},...]
        'meta',
        'status',
        'type',
        'student_note',
        'staff_confirmed_by',
        'teacher_confirmed',
        'teacher_confirmed_at',
        'student_confirmed',
        'student_confirmed_at',
        'teacher_id',
        'salary_at',
    ];

    public static $durationTypes = [
        self::TYPE_NORMAL,
        self::TYPE_MAKEUP,
        self::TYPE_TEST,
        self::TYPE_BONUS,
        self::TYPE_COMPENSATION,
    ];

    public static $passedDurationTypes = [
        self::TYPE_NORMAL,
        self::TYPE_MAKEUP,
        self::TYPE_TEST,
    ];

    public static $notDurationTypes = [
        self::TYPE_PENALTY,
    ];

    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = json_encode(empty($value) ? [] : $value);
    }

    public function getMetaAttribute()
    {
        return empty($this->attributes['meta']) ? [] : json_decode($this->attributes['meta'], true);
    }

    public function setLinksAttribute($value)
    {
        $this->attributes['links'] = json_encode(empty($value) ? [] : $value);
    }

    public function getLinksAttribute()
    {
        if (empty($this->attributes['links'])) {
            return [];
        }

        $links = json_decode($this->attributes['links'], true);

        return $links === false ? [] : $links;
    }

    public function getAttachmentsAttribute()
    {
        if (empty($this->attributes['attachments'])) {
            return [];
        }

        $attachments = json_decode($this->attributes['attachments'], true);

        return $attachments === false ? [] : $attachments;
    }

    public function getFormattedOccurredAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'longTime', $this->attributes['occurred_at']);
    }

    public function getFormattedTeacherConfirmedAtAttribute()
    {
        return empty($this->attributes['teacher_confirmed_at']) ? null : DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'shortTime', $this->attributes['teacher_confirmed_at']);
    }

    public function getTeacherAutoConfirmedAttribute()
    {
        $meta = $this->meta;
        if ($this->attributes['teacher_confirmed'] != 1 || !isset($meta['is_teacher_auto_confirm'])) {
            return null;
        }
        return $meta['is_teacher_auto_confirm'];
    }

    public function getFormattedStudentConfirmedAtAttribute()
    {
        return empty($this->attributes['student_confirmed_at']) ? null : DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'shortTime', $this->attributes['student_confirmed_at']);
    }

    public function getStudentAutoConfirmedAttribute()
    {
        $meta = $this->meta;
        if ($this->attributes['student_confirmed'] != 1 || !isset($meta['is_student_auto_confirm'])) {
            return null;
        }
        return $meta['is_student_auto_confirm'];
    }

    public function getFormattedSalaryAtAttribute()
    {
        return empty($this->attributes['salary_at']) ? null : DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'shortTime', $this->attributes['salary_at']);
    }

    public function setAttachmentsAttribute($value)
    {
        $this->attributes['attachments'] = json_encode(empty($value) ? [] : $value);
    }

    public function lesson()
    {
        return $this->belongsTo(Curriculum::class, 'refer_curriculum_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function sendConfirmSessionNotification($notifyContent = '')
    {
        $this->notify(new SessionConfirmNotification($this, settings(), $notifyContent));
    }

    public function sendUpdateSessionDatetimeNotification($oldOccurred, $oldDuration, $notifyContent = '')
    {
        $this->notify(new SessionChangeDatetimeNotification($this, settings(), $oldOccurred, $oldDuration, $notifyContent));
    }

    public function informs()
    {
        return $this->hasMany(CourseInform::class, 'session_id');
    }

    public function requestAbsenceInform()
    {
        $inform = $this->informs()->orderBy('created_at', 'DESC')->first();

        if (!$inform) {
            return null;
        }

        if ($inform->type == CourseInform::TYPE_REQUEST_ABSENCE) {
            return $inform;
        }

        return null;
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

    public function rates()
    {
        return $this->belongsToMany(Review::class, 'courses_reviews', 'session_id', 'review_id');
    }
}
