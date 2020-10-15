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

class Meta extends Model
{
    const TYPE_TEACHER_TRAINING_CATEGORY = 1;
    const TYPE_ABOUT_ARTICLE = 2;

    use Translatable;

    protected $table = 'meta';

    protected $fillable = [
        'name',
        'description',
        'order',
        'type',
    ];

    protected $translationForeignKey = 'meta_id';
    public $translatedAttributes = [
        'name',
        'description',
    ];
    public $useTranslationFallback = true;

    public function getLocaledTranslationsAttribute()
    {
        $translations = [];

        foreach ($this->translations as $trans) {
            $translations[$trans['locale']] = [
                'name' => $trans->name,
                'description' => $trans->description,
            ];
        }

        return $translations;
    }

    public function teacherTrainings()
    {
        return $this->hasMany(TeacherTraining::class, 'category_id', 'id')->orderBy('order', 'asc');
    }

    public function teacherTrainingsEnable()
    {
        return $this->hasMany(TeacherTraining::class, 'category_id', 'id')->where('enabled', '=', 1)->orderBy('order', 'asc');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'meta_id', 'id')->where('type', Article::TYPE_ABOUT)->orderBy('order', 'asc');
    }
}