<?php
/**
 * @author Tai.Nguyen
 */

namespace Katniss\Everdeen\Models;


use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;
use Katniss\Everdeen\Utils\NumberFormatHelper;

class Price extends Model
{
    protected $table = 'price_list';

    protected $fillable = [
        'created_by',
        'title',
        'topic_id',
        'teacher_group_id',
        'duration',
        'price',
        'special_price',
        'currency',
        'applied_from',
    ];

    public function topic()
    {
        return $this->belongsTo(LearningTopic::class, 'topic_id', 'id');
    }

    public function teacherGroup()
    {
        return $this->belongsTo(TeacherGroup::class, 'teacher_group_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_prices', 'price_id', 'tag_id');
    }

    public function getFormattedPriceAttribute()
    {
        return NumberFormatHelper::getInstance()
            ->formatCurrency($this->attributes['price'], $this->attributes['currency']);
    }

    public function getFormattedSpecialPriceAttribute()
    {
        return NumberFormatHelper::getInstance()
            ->formatCurrency($this->attributes['special_price'], $this->attributes['currency']);
    }

    public function getFormattedCreatedAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'longTime', $this->attributes['created_at']);
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'longTime', $this->attributes['updated_at']);
    }

    public function getFormattedAppliedFromAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'longTime', $this->attributes['applied_from']);
    }
}