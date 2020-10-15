<?php
/**
 * @author Tran Ngoc Hieu.
 * Date: 2017-06-21
 * Time: 10:40
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class ContactDivideHistory extends Model
{
    protected $table = 'contact_divide_history';

    protected $fillable = [
        'user_id',
        'data',
        'note',
    ];

    public function getDataAttribute()
    {
        return empty($this->attributes['data']) ? [] : json_decode($this->attributes['data'], true);
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode(empty($value) ? [] : $value);
    }
}