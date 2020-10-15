<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;

class UserNote extends Model
{   
    const TYPE_TEXT = 'text';
    const TYPE_TO_DO_LIST = 'to_do_list';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'data',
        'pinned',
    ];

    public function getDataAttribute()
    {
        return empty($this->attributes['data']) ? [] : json_decode($this->attributes['data'], true);
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode(empty($value) ? [] : $value);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getCreatedAtAttribute()
    {
        return DateTimeHelper::full($this->attributes['created_at']);
    }
}
