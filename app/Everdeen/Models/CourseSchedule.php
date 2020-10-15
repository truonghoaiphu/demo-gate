<?php
/**
 * @author Tai.Nguyen
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSchedule extends Model
{

    protected $table = 'course_schedules';

    protected $fillable = [
        'course_id',
        'day_of_week_from',
        'time_from',
        'day_of_week_to',
        'time_to'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}