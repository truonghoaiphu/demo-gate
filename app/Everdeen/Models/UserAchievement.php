<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class UserAchievement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_achievements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'got_at',
        'title',
        'description'
    ];

    public function works()
    {
        return $this->belongsToMany(UserWork::class, 'user_work_achievements', 'achievement_id', 'work_id');
    }

}
