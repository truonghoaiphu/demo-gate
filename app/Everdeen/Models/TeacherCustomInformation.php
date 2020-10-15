<?php
/**
 * @author Tai.Nguyen <tai.nguyen@antoree.com>
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherCustomInformation extends Model
{
    public $timestamps = true;

    protected $table = 'teacher_custom_information';

    protected $fillable = [
        'teacher_id',
        'title',
        'content',
        'order',
    ];

    public function teacher () {
    	return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }
}