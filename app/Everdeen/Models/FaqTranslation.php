<?php
/**
 * User: Tran ngoc hieu
 * Date: 2017-04-30
 * Time: 11:40
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class FaqTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'faq_translations';

    protected $fillable = [
        'question',
        'answer',
        'slug',
    ];
}