<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\AppConfig;
use Katniss\Everdeen\Utils\DateTimeHelper;

class UserTask extends Model
{
    const TYPE_TEXT = 'text';
    const TYPE_TO_DO_LIST = 'to_do_list';
    const STATUS_ON = 1;
    const STATUS_OFF = 0;

    const REMIND_TYPE_TIME = 'time';
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'refer_table',
        'refer_id',
        'title',
        'data',
        'reminded_at',
        'occurred_at',
        'notified_at',
        'status',
        'type',
    ];

    public function getDataAttribute()
    {
        return empty($this->attributes['data']) ? [] : json_decode($this->attributes['data'], true);
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode(empty($value) ? [] : $value);
    }

    public function getRemindedAtAttribute()
    {
        $remindedAt = json_decode($this->attributes['reminded_at'], true);
        $remindedAt['value'] = DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'shortTime', $remindedAt['value']);
        return $remindedAt;
    }

    public function setRemindedAtAttribute($value)
    {
        $this->attributes['reminded_at'] = json_encode(empty($value) ? [] : $value);
    }

    public function getFormattedOccurredAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'shortTime', $this->attributes['occurred_at']);
    }

    public function getFormattedCreatedAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'longTime', $this->attributes['created_at']);
    }

    public function getFormattedNotifiedAtAttribute()
    {
        return empty($this->attributes['notified_at']) ? '' :
            DateTimeHelper::getInstance()
                ->compound('shortDate', ' ', 'shortTime', $this->attributes['notified_at']);
    }

    public function getShortenedContentAttribute()
    {
        $data = $this->data;
        $content = '';
        if ($data['type'] == UserTask::TYPE_TEXT) {
            $content = mb_strimwidth($data['content'], 0, AppConfig::TITLE_SHORTEN_TEXT_LENGTH, '...');
        } else if ($data['type'] == UserTask::TYPE_TO_DO_LIST) {
            foreach ($data['content'] as $toDo) {
                $content .= ' ' . $toDo['text'];
            }
            $content = mb_strimwidth($content, 0, AppConfig::TITLE_SHORTEN_TEXT_LENGTH, '...');
        }

        return $content;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
