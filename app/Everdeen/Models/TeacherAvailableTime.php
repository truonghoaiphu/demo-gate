<?php
/**
 * @author Tai.Nguyen <tai.nguyen@antoree.com>
 * @since  2017-05-30 
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAvailableTime extends Model
{
    public $timestamps = true;

    protected $table = 'teacher_available_times';

    protected $fillable = [
        'user_id',
        'topic_id',
        'day_of_week_from',
        'time_from',
        'day_of_week_to',
        'time_to',
        'status'
    ];

    public function user () {
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }
}