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

class FaqTopic extends Model
{
    use Translatable;

    const PRIVATE_TRUE = 1;
    const PRIVATE_FALSE = 0;

    const IS_POPULAR_TRUE = 1;
    const IS_POPULAR_FALSE = 0;
    
    protected $table = 'faq_topics';

    protected $fillable = [
        'name',
        'description',
        'slug',
        'image',
        'private',
        'permissions',
        'is_popular',
        'order',
    ];

    protected $translationForeignKey = 'topic_id';
    public $translatedAttributes = [
        'name',
        'description',
        'slug',
    ];
    public $useTranslationFallback = true;

    public function setPermissionsAttribute($value)
    {
        $this->attributes['permissions'] = json_encode(empty($value) ? [] : $value);
    }

    public function getPermissionsAttribute()
    {
        return empty($this->attributes['permissions']) ? [] : json_decode($this->attributes['permissions'], true);
    }
}