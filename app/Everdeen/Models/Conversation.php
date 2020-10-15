<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Katniss\Everdeen\Utils\AppConfig;
use Katniss\Everdeen\Utils\DateTimeHelper;

class Conversation extends Model
{
    const TYPE_PUBLIC = 0; // auth + anonymous
    const TYPE_DIRECT = 1; // 1-1 auth
    const TYPE_GROUP = 2; // * auth
    const TYPE_SUPPORT = 3; // *anonymous-1 auth

    protected $table = 'conversations';

    protected $fillable = [
        'channel_id',
        'name',
        'type',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function getIsPublicAttribute()
    {
        return $this->attributes['type'] == $this::TYPE_PUBLIC;
    }

    public function getIsDirectAttribute()
    {
        return $this->attributes['type'] == $this::TYPE_DIRECT;
    }

    public function getIsGroupAttribute()
    {
        return $this->attributes['type'] == $this::TYPE_GROUP;
    }

    public function getIsSupportAttribute()
    {
        return $this->attributes['type'] == $this::TYPE_SUPPORT;
    }

    public function getUpdatedAtAttribute()
    {
        return DateTimeHelper::full($this->attributes['updated_at']);
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return DateTimeHelper::getInstance()->compound('shortDate', ' ', 'shortTime', $this->attributes['updated_at']);
    }

    public function getLastMessageAttribute()
    {
        return $this->messages()->orderBy('created_at', 'desc')->first();
    }

    public function channel()
    {
        return $this->hasOne(Channel::class, 'id', 'channel_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'conversations_users', 'conversation_id', 'user_id');
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'conversations_devices', 'conversation_id', 'device_id')
            ->withPivot('color');
    }

    public function getLastMessages($count = AppConfig::DEFAULT_ITEMS_PER_PAGE)
    {
        return $this->messages()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take($count)
            ->get();
    }
}
