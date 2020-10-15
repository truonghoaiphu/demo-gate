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

class TeacherTraining extends Model
{
    use Translatable;

    const ENABLE = 1;
    const DISABLE = 0;

    protected $table = 'teacher_trainings';

    protected $fillable = [
        'category_id',
        'order',
        'has_video',
        'has_test',
        'ended',
        'enabled',

        'title',
        'content',
        'url_video',
        'video_transcript',
    ];

    protected $translationForeignKey = 'training_id';
    public $translatedAttributes = [
        'title',
        'content',
        'url_video',
        'video_transcript',
    ];
    public $useTranslationFallback = true;

    public function getLocaledTranslationsAttribute()
    {
        $translations = [];

        foreach ($this->translations as $trans) {
            $translations[$trans['locale']] = [
                'title' => $trans->title,
                'content' => $trans->content,
                'url_video' => $trans->url_video,
                'video_transcript' => $trans->video_transcript,
            ];
        }

        return $translations;
    }

    public function getShortenContentAttribute()
    {
        return shorten($this->content);
    }

    public function getHtmlContentAttribute()
    {
        return nl2br($this->content);
    }

    public function getShortenVideoTranscriptAttribute()
    {
        return shorten($this->video_transcript);
    }

    public function getHtmlVideoTranscriptAttribute()
    {
        return nl2br($this->video_transcript);
    }

    public function getHasVideoAttribute()
    {
        return $this->attributes['has_video'] == 1;
    }

    public function getHasTestAttribute()
    {
        return $this->attributes['has_test'] == 1;
    }

    public function getIsEndedAttribute()
    {
        return $this->attributes['ended'] == 1;
    }

    public function getEnabledAttribute()
    {
        return $this->attributes['enabled'] == 1;
    }

    public function category()
    {
        return $this->belongsTo(Meta::class, 'category_id', 'id');
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'teacher_training_attachments', 'training_id', 'attachment_id')
            ->withPivot('order')
            ->orderBy('order', 'asc');
    }

    public function commentThreads()
    {
        return $this->belongsToMany(CommentThread::class, 'teacher_training_threads', 'training_id', 'thread_id');
    }

    public function trainedTeachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_trained', 'training_id', 'teacher_id');
    }
}