<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    const TYPE_FILE = 1;
    const TYPE_LINK = 2;

    const GROUP_COMMON = 1;
    const GROUP_TEACHER_TRAINING = 2;

    protected $table = 'attachments';

    protected $fillable = [
        'created_by',
        'hashed',
        'url',
        'meta',
        'type',
        'group',
    ];

    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = json_encode(empty($value) ? [] : $value);
    }

    public function getMetaAttribute()
    {
        if (empty($this->attributes['meta'])) {
            return [];
        }

        $meta = json_decode($this->attributes['meta'], true);
        return $meta === false ? [] : $meta;
    }
}
