<?php
/**
 * User: Tran ngoc hieu
 * Date: 2017-04-30
 * Time: 11:40
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class FaqTopicTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'faq_topic_translations';

    protected $fillable = [
        'name',
        'description',
    ];
}