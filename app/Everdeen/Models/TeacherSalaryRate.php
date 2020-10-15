<?php
/**
 * @author Thang.Nguyen
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Katniss\Everdeen\Utils\NumberFormatHelper;
use Katniss\Everdeen\Utils\DateTimeHelper;

class TeacherSalaryRate extends Model
{
    protected $table = 'teacher_salary_rates';

    protected $fillable = [
        'teacher_id',
        'course_id',
        'topic_id',
        'hourly_amount',
        'amount_currency',
        'changed_reason',
        'changed_at',
    ];

    public function getAmountAttribute()
    {
        return NumberFormatHelper::getInstance()->format($this->attributes['hourly_amount'])
            . ' ' . $this->attributes['amount_currency'];
    }

    public function topic()
    {
        return $this->belongsTo(LearningTopic::class, 'topic_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'user_id');
    }

    public function getChangedAtAttribute()
    {
        return DateTimeHelper::getInstance()->shortDate($this->attributes['changed_at']);
    }
}
