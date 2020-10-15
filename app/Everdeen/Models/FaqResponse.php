<?php
/**
 * @author Tai.Nguyen
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class FaqResponse extends Model
{

    protected $table = 'faq_responses';

    protected $fillable = [
        'topic_id',
        'created_by',
        'name',
        'email',
        'phone',
        'ip',
        'device',
        'message',
    ];
}
