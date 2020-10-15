<?php
/**
 * Created by: Thang.Nguyen <thang.nguyen@antoree.com>
 * Created on: 2017-06-13
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use Katniss\Everdeen\Utils\DateTimeHelper;

class Faq extends Model
{
    use Translatable;
    protected $table = 'faqs';

    const IS_TOP_TRUE = 1;
    const IS_TOP = 0;

    const PRIVATE_TRUE = 1;
    const PRIVATE_FALSE = 0;

    protected $fillable = [
        'topic_id',
        'order',
        'created_by',
        'private',
        'permissions',
        'is_top',
        'question',
        'answer',
        'slug',
    ];

    protected $translationForeignKey = 'faq_id';
    public $translatedAttributes = [
        'question',
        'answer',
        'slug',
    ];
    public $useTranslationFallback = true;

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function topic()
    {
        return $this->belongsTo(FaqTopic::class, 'topic_id', 'id');
    }

    public function setPermissionsAttribute($value)
    {
        $this->attributes['permissions'] = json_encode(empty($value) ? [] : $value);
    }

    public function getPermissionsAttribute()
    {
        return empty($this->attributes['permissions']) ? [] : json_decode($this->attributes['permissions'], true);
    }
}
