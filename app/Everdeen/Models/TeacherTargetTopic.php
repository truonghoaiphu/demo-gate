<?php
/**
 * @author Tai.Nguyen <tai.nguyen@antoree.com>
 * @since  2017-05-30 
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherTargetTopic extends Model
{
    public $timestamps = false;

    protected $table = 'teacher_target_topics';

    protected $fillable = [
        'user_id',
        'topic_id'
    ];
}