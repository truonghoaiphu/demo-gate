<?php
/**
 * @author Tran Ngoc Hieu.
 * Date: 2017-06-21
 * Time: 10:40
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;

class ContactConvertHistory extends Model
{
    protected $table = 'contact_convert_history';

    protected $fillable = [
        'user_id',
        'data',
        'note',
    ];

    public function getFormattedCreatedAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'shortTime', $this->attributes['created_at']);
    }

    public function getDataAttribute()
    {
        return empty($this->attributes['data']) ? [] : json_decode($this->attributes['data'], true);
    }

    public function getCountItemsAttribute()
    {
        $data = $this->data;
        return empty($data) ? 0 : $data['count_items'];
    }

    public function getCountConflictAttribute()
    {
        $data = $this->data;
        return empty($data) ? 0 : $data['count_conflict'];
    }

    public function getIdsConflictAttribute()
    {
        $data = $this->data;
        return empty($data) ? 0 : $data['ids_conflict'] ? explode(',', (string)$data['ids_conflict']) :[];
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode(empty($value) ? [] : $value);
    }

    public function runner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}