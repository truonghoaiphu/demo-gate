<?php
/**
 * @author Tai.Nguyen
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class FaqFeedback extends Model
{

    const HELPFUL_NO = 0;
    const HELPFUL_YES = 1;

    protected $table = 'faq_feedbacks';

    protected $fillable = [
        'faq_id',
        'created_by',
        'reason_type',
        'helpful',
        'ip',
        'device',
        'message',
    ];
}
