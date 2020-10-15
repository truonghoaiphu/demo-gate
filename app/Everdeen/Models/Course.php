<?php
/**
 * @refactored
 * @author Tran Ngoc Hieu.
 * Date: 2017-06-21
 * Time: 10:40
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;
use Katniss\Everdeen\Utils\NumberFormatHelper;

class Course extends Model
{
    const STATUS_OPEN = 0; // open
    const STATUS_CURRENT = 1; // learning (open)
    const STATUS_CANCELLED = 2; // end when not learn
    const STATUS_ABORTED = 3; // end in the middle of course
    const STATUS_ENDED = 4; // end when learn all
    const STATUS_PENDING = 5; // pause
    const STATUS_DELAY = 6; // delay
    const STATUS_CLOSED = 10; // end totally (close)

    const TYPE_NEW = 1; // new
    const TYPE_CHANGE_TEACHER = 2; // change teacher
    const TYPE_CHANGE_TRANSFER = 3; // transfer
    const TYPE_DEMO = 4; // demo
    const TYPE_TRIAL = 5; // demo

    const CERTIFICATE_PROVIDED = 3; // transfer

    const KID = 'kid';
    const WORK = 'work';

    const KID_HOURS_GET_REVIEW = 15;
    const WORK_HOURS_GET_REVIEW = 12;

    const DURATION_RETENTION = 10; //10 days

    const RETENTION_STATUS_NOT_SET = 0;
    const RETENTION_STATUS_NO = 1;
    const RETENTION_STATUS_YES = 2;
    const RATIO_NULL = '-';
    
    //init property
    protected $createdFromDate = null;
    protected $createdToDate = null;

    const DEFAULT_CURRENCY = 'VND';

    protected $table = 'courses';
    protected $fillable = [
        'student_id',
        'teacher_id',
        'created_by',
        'cared_by',
        'curriculum_id',
        'refer_request_id',
        'refer_course_id',
        'title',
        'duration',
        'passed_duration',
        'makeup_duration',
        'passed_makeup_duration',
        'price',
        'started_at',
        'ended_at',
        'capability_ids',
        'tag_ids',
        'meta',
        'bonus_duration',
        'passed_bonus_duration',
//        'closed_at',
//        'salary',
//        'salary_currency',
//        'hourly_salary',
//        'hourly_price',
//        'take_care',
//        'monthly_duration',
//        'bonus_salary',
//        'retention_note',
        'type',
        'status',
        'topic_id',
        'tuition_code',
        'retention_status',
        'price_currency',
        'original_price',
    ];

    public function getFormattedStartedAtAttribute()
    {
        return $this->attributes['started_at'] ? DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'longTime', $this->attributes['started_at']) : null;
    }

    public function getFormattedEndedAtAttribute()
    {
        return $this->attributes['ended_at'] ? DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'longTime', $this->attributes['ended_at']) : null;
    }
    
    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = json_encode(empty($value) ? [] : $value);
    }

    public function getMetaAttribute()
    {
        return empty($this->attributes['meta']) ? [] : json_decode($this->attributes['meta'], true);
    }

    public function learningRequest()
    {
        return $this->belongsTo(LearningRequest::class, 'refer_request_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_courses', 'course_id', 'tag_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'user_id');
    }

    public function studentUserProfile()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'user_id');
    }

    public function teacherUserProfile()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    public function carer()
    {
        return $this->belongsTo(User::class, 'cared_by', 'id');
    }

    public function topic()
    {
        return $this->belongsTo(LearningTopic::class, 'topic_id', 'id');
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

    public function getScheduleAttribute()
    {
        return empty($this->attributes['schedule']) ? [] : json_decode($this->attributes['schedule'], true);
    }

    public function setScheduleAttribute($value)
    {
        $this->attributes['schedule'] = json_encode(empty($value) ? [] : $value);
    }

    public function courseSchedules()
    {
        return $this->hasMany(CourseSchedule::class, 'course_id', 'id');
    }

    public function sessions()
    {
        return $this->hasMany(CourseSession::class, 'course_id', 'id');
    }

    public function reviews()
    {
        return $this->belongsToMany(Review::class, 'courses_reviews', 'course_id', 'review_id');
    }

    public function courseAborts()
    {
        return $this->hasMany(CourseAbort::class, 'course_id', 'id');
    }

    public function getFormattedPriceAttribute()
    {
        return NumberFormatHelper::getInstance()
            ->formatCurrency($this->attributes['price'], $this->attributes['price_currency']);
    }

    public function getFormattedDurationAttribute()
    {
        return NumberFormatHelper::getInstance()
            ->format($this->attributes['duration']);
    }

    public function getFormattedPenaltyDurationAttribute()
    {
        return NumberFormatHelper::getInstance()
            ->format($this->attributes['penalty_duration'] != null ? $this->attributes['penalty_duration'] : 0);
    }

    //Thang.Nguyen
    public function getFormattedBonusDurationAttribute()
    {
        return NumberFormatHelper::getInstance()
            ->format($this->attributes['bonus_duration'] != null ? $this->attributes['bonus_duration'] : 0);
    }

    //Thang.Nguyen
    public function getFormattedPassedBonusDurationAttribute()
    {
        return NumberFormatHelper::getInstance()
            ->format($this->attributes['passed_bonus_duration'] != null ? $this->attributes['passed_bonus_duration'] : 0);
    }

    public function getFormattedMakeupDurationAttribute()
    {
        return NumberFormatHelper::getInstance()
            ->format($this->attributes['makeup_duration']);
    }

    public function getFormattedPassingDurationAttribute()
    {
        // return NumberFormatHelper::getInstance()
        //     ->format($this->sessions->where('status', CourseSession::STATUS_COMPLETED)->sum('duration'));
        return NumberFormatHelper::getInstance()
            ->format($this->attributes['passed_duration']);
    }

    public function getFormattedRemainingDurationAttribute()
    {
        // return NumberFormatHelper::getInstance()
        //     ->format($this->attributes['duration'] - $this->sessions->where('status', CourseSession::STATUS_COMPLETED)->sum('duration'));
        return NumberFormatHelper::getInstance()
            ->format($this->attributes['duration'] - $this->attributes['passed_duration']);
    }

    public function getTeacherAvgAttribute()
    {
        $avgRate =  $this->reviews->where('type', Review::REVIEW_COURSE_TEACHER)
                        ->where('avg_rate', '>', 0)
                        ->avg('avg_rate');
        return NumberFormatHelper::getInstance()
            ->format($avgRate);
    }

    public function getCarerAvgAttribute()
    {
        $avgRate =  $this->reviews->where('type', Review::REVIEW_COURSE_CARER)->avg('avg_rate');
        return NumberFormatHelper::getInstance()
            ->format($avgRate);
    }

    public function getCountSessionsAttribute()
    {
        return $this->sessions->count();
    }

    public function getLearningHoursPerMonthAttribute()
    {   
        $meta = $this->getMetaAttribute();
        return NumberFormatHelper::getInstance()
            ->format((!empty($meta['monthly_duration']) && $meta['monthly_duration'] != 0 && $this->attributes['passed_duration']) ? ($this->attributes['passed_duration'] / $meta['monthly_duration']) : 0);
    }

    public function setTagIdsAttribute($value)
    {
        $this->attributes['tag_ids'] = json_encode(empty($value) ? [] : $value);
    }

    public function getTagIdsAttribute()
    {
        return empty($this->attributes['tag_ids']) ? [] : json_decode($this->attributes['tag_ids'], true);
    }

    public function setCapabilityIdsAttribute($value)
    {
        $this->attributes['capability_ids'] = json_encode(empty($value) ? [] : $value);
    }

    public function getCapabilityIdsAttribute()
    {
        return empty($this->attributes['capability_ids']) ? [] : json_decode($this->attributes['capability_ids'], true);
    }

    public function salaryRates()
    {
        return $this->hasMany(TeacherSalaryRate::class, 'course_id');
    }

    //for rating review
    //Tai.Nguyen
    
    public function totalRating($type = null)
    {   
        $reviews = $this->reviews;

        if (!empty($type)) {
            $reviews->where('type', $type);
        }
        
        return  NumberFormatHelper::getInstance()
            ->format($reviews->avg('avg_rate'));
    }

    public function ratingAverage($createdFromDate = null, $createdToDate = null, $type = null)
    {   
        $reviews = $this->reviews;

        if (!empty($type)) {
            $reviews->where('type', $type);
        }

        if (!empty($createdFromDate)) {
            $reviews->where('created_at', '>', $createdFromDate);
        }

        if (!empty($createdToDate)) {
            $reviews->where('created_at', '<', $createdToDate);
        }

        $ratingAvg = $reviews->avg('avg_rate');

        return NumberFormatHelper::getInstance()
            ->format($ratingAvg);
    }

    public function teachingContentRating($createdFromDate = null, $createdToDate = null, $type = null)
    {   
        $reviews = $this->reviews;
        
        if (!empty($type)) {
            $reviews->where('type', $type);
        }

        if (!empty($createdFromDate)) {
            $reviews->where('created_at', '>', $createdFromDate);
        }

        if (!empty($createdToDate)) {
            $reviews->where('created_at', '<', $createdToDate);
        }

        $countTeachingContentRating = 0;
        $totalTeachingContentRating = 0;

        foreach ($reviews as $review) {
            $rates = $review->details;
            foreach ($rates as $rate) {
                if (!empty($rate->id) && $rate->id == Review::RATE_CURRICULUM_CONTENT) {
                    $countTeachingContentRating++;
                    $totalTeachingContentRating = $totalTeachingContentRating + $rate->value;
                }
            }
        }

        $teachingContentRatingAvg =  $countTeachingContentRating > 0 ? ($totalTeachingContentRating / $countTeachingContentRating) : 0;

        return NumberFormatHelper::getInstance()
            ->format($teachingContentRatingAvg);
    }

    public function teachingMethodRating($createdFromDate = null, $createdToDate = null, $type = null)
    {
        $reviews = $this->reviews;
        
        if (!empty($type)) {
            $reviews->where('type', $type);
        }

        if (!empty($createdFromDate)) {
            $reviews->where('created_at', '>', $createdFromDate);
        }

        if (!empty($createdToDate)) {
            $reviews->where('created_at', '<', $createdToDate);
        }

        $countTeachingMethodRating = 0;
        $totalTeachingMethodRating = 0;

        foreach ($reviews as $review) {
            $rates = $review->details;
            foreach ($rates as $rate) {
                if (!empty($rate['id']) && $rate['id'] == Review::RATE_TEACHING_METHOD) {
                    $countTeachingMethodRating++;
                    $totalTeachingMethodRating = $totalTeachingMethodRating + $rate['rated'];
                }
            }
        }

        $teachingMethodRatingAvg =  $countTeachingMethodRating > 0 ? ($totalTeachingMethodRating / $countTeachingMethodRating) : 0;

        return NumberFormatHelper::getInstance()
            ->format($teachingMethodRatingAvg);
    }

    public function workingAttitudeRating($createdFromDate = null, $createdToDate = null, $type = false)
    {
        $reviews = $this->reviews;
        
        if (!empty($type)) {
            $reviews->where('type', $type);
        }

        if (!empty($createdFromDate)) {
            $reviews->where('created_at', '>', $createdFromDate);
        }

        if (!empty($createdToDate)) {
            $reviews->where('created_at', '<', $createdToDate);
        }

        $countWorkingAttitudeRating = 0;
        $totalWorkingAttitudeRating = 0;

        foreach ($reviews as $review) {
            $rates = $review->details;
            foreach ($rates as $rate) {
                if (!empty($rate['id']) && $rate['id'] == Review::RATE_ATTITUDE) {
                    $countWorkingAttitudeRating++;
                    $totalWorkingAttitudeRating = $totalWorkingAttitudeRating + $rate['rated'];
                }
            }
        }

        $workingAttitudeAvg =  $countWorkingAttitudeRating > 0 ? ($totalWorkingAttitudeRating / $countWorkingAttitudeRating) : 0;

        return NumberFormatHelper::getInstance()
            ->format($workingAttitudeAvg);
    }

    public function learnerImprovementRating($createdFromDate = null, $createdToDate = null, $type = false)
    {
        $reviews = $this->reviews;
        
        if (!empty($type)) {
            $reviews->where('type', $type);
        }

        if (!empty($createdFromDate)) {
            $reviews->where('created_at', '>', $createdFromDate);
        }

        if (!empty($createdToDate)) {
            $reviews->where('created_at', '<', $createdToDate);
        }

        $countLearnerImprovementRating = 0;
        $totalLearnerImprovementRating = 0;

        foreach ($reviews as $review) {
            $rates = $review->details;
            foreach ($rates as $rate) {
                if (!empty($rate['id']) && $rate['id'] == Review::RATE_SATISFACTION) {
                    $countLearnerImprovementRating++;
                    $totalLearnerImprovementRating = $totalLearnerImprovementRating + $rate['rated'];
                }
            }
        }

        $learnerImprovementAvg =  $countLearnerImprovementRating > 0 ? ($totalLearnerImprovementRating / $countLearnerImprovementRating) : 0;

        return NumberFormatHelper::getInstance()
            ->format($learnerImprovementAvg);
    }

    //init property
    public function setCreateFromDateAttribute($value)
    {
        return $this->createdFromDate = $value;
    }

    public function setCreateToDateAttribute($value)
    {
        return $this->createdToDate = $value;
    }

}