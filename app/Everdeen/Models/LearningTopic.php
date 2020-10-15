<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2017-04-30
 * Time: 11:24
 */

namespace Katniss\Everdeen\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class LearningTopic extends Model
{
    use Translatable;

    const MARKING_TYPE_TOIEC = 8;
    const MARKING_TYPE_IELTS = 7;

    protected $table = 'learning_topics';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'marking_type',
    ];

    protected $translationForeignKey = 'topic_id';
    public $translatedAttributes = [
        'name',
        'slug',
        'description',
    ];
    public $useTranslationFallback = true;

    public function users()
    {
        return $this->belongsToMany(User::class, 'teacher_target_topics', 'topic_id', 'user_id');
    }

    public function capabilities()
    {
        return $this->hasMany(LearningCapability::class, 'topic_id', 'id');
    }
    
    public function tags()
    {
        return $this->hasMany(LearningTag::class, 'topic_id', 'id');
    }

    public function salaryRates()
    {
        return $this->hasMany(TeacherSalaryRate::class, 'topic_id');
    }
}