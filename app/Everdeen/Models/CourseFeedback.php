<?php
/**
 * @author  Tai.Nguyen
 * @since  2017-07-18
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;

class CourseFeedback extends Model
{
    const STATUS_TEACHER_ANTOREE_AND_ME = 1;
    const STATUS_ANTOREE_AND_ME = 2;

    protected $table = 'course_feedbacks';

    protected $fillable = [
        'course_id',
        'created_by',
        'value',
        'content',
        'status',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
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
}
