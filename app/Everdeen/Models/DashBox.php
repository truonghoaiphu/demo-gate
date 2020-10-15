<?php
/**
 * @author Tran Ngoc Hieu.
 * Date: 2017-07-05
 * Time: 10:00
 */
namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class DashBox extends Model
{
    const USED_MANAGER = 1;
    const USED_MEMBER = 2;

    protected $table = 'dash_boxes';

    protected $fillable = [
        'display_name',
        'name',
        'description',
        'team_types',
        'used_for',
        'enable',
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'users_dash_boxes', 'dash_box_id', 'user_id');
    }
}
