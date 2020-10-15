<?php
namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;
use Katniss\Everdeen\Utils\NumberFormatHelper;

class TopicSalaryRate extends Model
{
    protected $table = 'topic_salary_rates';

    protected $fillable = [
        'teacher_id',
        'topic_id',
        'hourly_amount',
        'amount_currency',
        'note',
        'type',
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
        return DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'shortTime', $this->attributes['changed_at']);
    }
}
