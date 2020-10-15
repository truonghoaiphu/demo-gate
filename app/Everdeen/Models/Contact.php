<?php
/**
 * @author Tran Ngoc Hieu.
 * Date: 2017-06-21
 * Time: 10:40
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Katniss\Everdeen\Utils\DateTimeHelper;

class Contact extends Model
{
    use SoftDeletes;

    const TYPE_NEW = 0;
    const TYPE_LEAD = 1;
    const TYPE_CONTACT = 2;
    const TYPE_CUSTOMER = 3;

    const STATUS_NEWLY = 0;
    const STATUS_CARING = 1;
    const STATUS_PENDING = 2;
    const STATUS_STOP = 3;

    const FILTER_CARED_BY_NONE = 0;
    const FILTER_CARED_BY_NULL = -1;
    const FILTER_CARED_BY_NOT_NULL = -2;

    const HALF_CUSTOMER_FALSE = 0;
    const HALF_CUSTOMER_TRUE = 1;

    // added by Thang.Nguyen
    const RELATION_KID = 1;
    const RELATION_FRIEND = 2;

    protected $table = 'contacts';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'created_by',
        'history_id',
        'attached_to',
        'cared_by',
        'half_cared_by',
        'half_customer',
        'name',
        'email',
        'trackedEmail',
        'phone',
        'trackedPhone',
        'skype',
        'level',
        'type',
        'status',

        'old_id',
    ];

    public function getMetaAttribute()
    {
        if (empty($this->attributes['meta'])) {
            return [];
        }

        $meta = json_decode($this->attributes['meta'], true);
        return $meta === false ? [] : $meta;
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

    public function carer()
    {
        return $this->belongsTo(User::class, 'cared_by', 'id');
    }

    public function halfCarer()
    {
        return $this->belongsTo(User::class, 'half_cared_by', 'id');
    }

    public function learningRequests()
    {
        return $this->hasMany(LearningRequest::class, 'held_by', 'id')->orderBy('created_at', 'desc');
    }

    public function histories()
    {
        return $this->hasMany(ContactHistory::class, 'contact_id', 'id');
    }

    public function userProfile()
    {
        return $this->belongsTo(User::class, 'attached_to', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_contacts', 'contact_id', 'tag_id');
    }

    public function getReportLearningRequestAttribute()
    {
        $report = [];

        $report[LearningRequest::LEVEL_NEWLY] = $this->learningRequests()->where('level', LearningRequest::LEVEL_NEWLY)->count();
        $report[LearningRequest::LEVEL_INVALID] = $this->learningRequests()->where('level', LearningRequest::LEVEL_INVALID)->count();
        $report[LearningRequest::LEVEL_VALID] = $this->learningRequests()->where('level', LearningRequest::LEVEL_VALID)->count();
        $report[LearningRequest::LEVEL_INFORMATION_GATHERING] = $this->learningRequests()->where('level', LearningRequest::LEVEL_INFORMATION_GATHERING)->count();
        $report[LearningRequest::LEVEL_MATCHING] = $this->learningRequests()->where('level', LearningRequest::LEVEL_MATCHING)->count();
        $report[LearningRequest::LEVEL_DEAL] = $this->learningRequests()->where('level', LearningRequest::LEVEL_DEAL)->count();
        $report[LearningRequest::LEVEL_PAYMENT] = $this->learningRequests()->where('level', LearningRequest::LEVEL_PAYMENT)->count();
        $report[LearningRequest::LEVEL_READY] = $this->learningRequests()->where('level', LearningRequest::LEVEL_READY)->count();

        return $report;
    }

    public function divideRequest()
    {
        return $this->hasMany(ContactDivideRequest::class);
    }

    public function childContacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_relations', 'main_id', 'related_id');
    }

    public function parentContacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_relations', 'related_id', 'main_id');
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

    public function cacheContactWith90dlrs()
    {
        return $this->hasMany(CacheContactWith90dlr::class, 'contact_id', 'id');
    }
}