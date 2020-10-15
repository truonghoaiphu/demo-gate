<?php
/**
 * @author Tran Ngoc Hieu.
 * Date: 2017-06-21
 * Time: 10:40
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;
use Katniss\Everdeen\Utils\NumberFormatHelper;

class CourseHistory extends Model
{
    protected $table = 'course_history';
    const TYPE_CREATE = 1;
    const TYPE_UPDATE = 2;
    const TYPE_DELETE = 3;
    protected $fillable = [
        'course_id',
        'user_id',
        'type',
        'data',
        'note',
    ];

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode(empty($value) ? [] : $value);
    }
}