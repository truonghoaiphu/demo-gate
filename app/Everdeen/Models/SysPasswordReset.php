<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class SysPasswordReset extends Model
{
    protected $table = 'sys_password_resets';

    protected $fillable = [
        'token',
        'email',
    ];
}
