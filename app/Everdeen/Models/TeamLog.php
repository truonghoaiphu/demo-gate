<?php
/**
 * Created by: Thang.Nguyen <thang.nguyen@antoree.com>
 * Created on: 2017-06-13
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class TeamLog extends Model
{
    protected $table = 'team_logs';

    protected $fillable = [
        'team_id',
        'user_id',
        'data',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getDataAttribute()
    {
        return empty($this->attributes['data']) ? [] : json_decode($this->attributes['data'], true);
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode(empty($value) ? [] : $value);
    }
}
