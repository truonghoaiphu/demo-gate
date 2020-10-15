<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2017-04-30
 * Time: 11:40
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherTrainingTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'teacher_training_translations';

    protected $fillable = [
        'title',
        'content',
        'url_video',
        'video_transcript',
    ];
}