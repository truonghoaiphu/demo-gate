<?php

/**
 * @author Tran Ngoc Hieu.
 * Date: 2017-06-21
 * Time: 10:40
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;

class LearningRequest extends Model
{
    const TYPE_SPAM = 0;
    const TYPE_CONSULTANT = 1;
    const TYPE_LEARNING_REQUEST = 2;

    const LEVEL_NEWLY = 1;
    const LEVEL_INVALID = 2;
    const LEVEL_VALID = 3;
    const LEVEL_INFORMATION_GATHERING = 4;
    const LEVEL_MATCHING = 5;
    const LEVEL_DEAL = 6;
    const LEVEL_PAYMENT = 7;
    const LEVEL_READY = 8;

    const STATUS_NEWLY = 0;
    const STATUS_CARING = 1;
    const STATUS_PENDING = 2;
    const STATUS_STOP = 3;

    const SOURCE_TYPE_CREATED = 1;
    const SOURCE_TYPE_IMPORTED = 2;
    const SOURCE_TYPE_LANDING_PAGE = 3;

    const REPORT_TYPE_DATE = 'date';
    const REPORT_TYPE_WEEK = 'week';
    const REPORT_TYPE_MONTH = 'month';
    const REPORT_TYPE_QUARTER = 'quarter';

    const CUSTOMER_LEVEL_NONE = 0;
    const CUSTOMER_LEVEL_NEWLY = 1;
    const CUSTOMER_LEVEL_RETENTION = 2;

    const RELATION_KID = 'kid';

    const PARENT_REGISTER = 1;
    const KID_REGISTER = 2;
    const STUDENT_REGISTER = 3;
    const WORK_REGISTER = 4;

    // level lr and sublevel
    const LEARNING_LEVELS = [
        1 => [101, 102, 103, 104, 105],
        2 => [201, 202, 203, 204, 205],
        3 => [301, 302, 303],
        4 => [401, 402],
        5 => [501, 502],
        6 => [601, 602],
        7 => [701],
        8 => [801],
    ];

    protected $table = 'learning_requests';

    protected $fillable = [
        'id',
        'created_by',
        'requested_to',
        'history_id',
        'held_by',
        'tmp_held_by',
        'name',
        'for_name',
        'for_relation',
        'email',
        'trackedEmail',
        'phone',
        'trackedPhone',
        'skype',
        'meta',
        'source',
        'level',
        'level_meta',
        'status',
        'note',
        'type',
        'customer_level',
        'tuition_code',
        'utm_source',
        'utm_campaign',
        'utm_term',
        'old_id',
    ];

    public function getFormattedCreatedAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'longTime', $this->attributes['created_at']);
    }

    public function getMetaAttribute()
    {
        return empty($this->attributes['meta']) ? [] : json_decode($this->attributes['meta'], true);
    }

    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = json_encode(empty($value) ? [] : $value);
    }

    public function getLevelMetaAttribute()
    {
        return empty($this->attributes['level_meta']) ? [] : json_decode($this->attributes['level_meta'], true);
    }

    public function setLevelMetaAttribute($value)
    {
        $this->attributes['level_meta'] = json_encode(empty($value) ? [] : $value);
    }

    public function getSourceAttribute()
    {
        return empty($this->attributes['source']) ? [] : json_decode($this->attributes['source'], true);
    }

    public function setSourceAttribute($value)
    {
        $this->attributes['source'] = json_encode(empty($value) ? [] : $value);
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'longTime', $this->attributes['updated_at']);
    }

    public function getCountTmpHeldByAttribute()
    {
        return empty($this->attributes['tmp_held_by']) ? 0 : count(explode(',', $this->attributes['tmp_held_by']));
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = $value;
        $this->trackedEmail = $value;
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = $value;
        $this->trackedPhone = $value;
    }

    public function setTrackedEmailAttribute($value)
    {
        $this->attributes['tracked_email'] = toTrackedEmail($value);
    }

    public function setTrackedPhoneAttribute($value)
    {
        $this->attributes['tracked_phone'] = toTrackedPhone($value);
    }

    public function heldBy()
    {
        return $this->belongsTo(Contact::class, 'held_by', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_learning_requests', 'request_id', 'tag_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'refer_request_id', 'id');
    }

    public function trialCourses()
    {
        return $this->hasMany(Course::class, 'refer_request_id', 'id')->where('type', '=', Course::TYPE_TRIAL);
    }

    public function claimRequests()
    {
        return $this->hasMany(ClaimRequest::class, 'request_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function teacherRequested()
    {
        return $this->belongsTo(User::class, 'requested_to', 'id');
    }

    public function cacheContactWith90dlrs()
    {
        return $this->hasMany(CacheContactWith90dlr::class, 'contact_id', 'id');
    }
}
