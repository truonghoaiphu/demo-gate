<?php
/**
 * Created by: Thang.Nguyen <thang.nguyen@antoree.com>
 * Created on: 2017-06-13
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    const TEAM_MARKETING = 1;
    const TEAM_SALE = 2;
    const TEAM_CMD = 3;
    const TEAM_TS = 4;

    protected $table = 'teams';

    protected $fillable = [
        'role_id',
        'managed_by',
        'name',
        'type',
        'has_sub',
        'code',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'managed_by', 'id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'teams_users', 'team_id', 'user_id');
    }

    public function allMembers()
    {
        $members = $this->members;
        $members->splice(0, 0, [$this->manager]);
        return $members;
    }
}
