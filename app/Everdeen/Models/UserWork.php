<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class UserWork extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_works';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'company',
        'position',
        'description',
        'start',
        'end',
        'current',
        'learner_number',
        'type',
        'meta',
        'order',
        'old_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($work) {
            $work->achievements()->delete();
        });
    }

    public function achievements()
    {
        return $this->belongsToMany(UserAchievement::class, 'user_work_achievements', 'work_id', 'achievement_id');
    }
}
