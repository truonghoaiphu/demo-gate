<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class SysToken extends Model
{
    const TYPE_LOGIN = 1;
    const TYPE_CONFIRM_LEARNER_PAYMENT = 2;
    const TYPE_CONFIRM_SESSION = 3; // meta will be session id

    protected $table = 'sys_tokens';

    protected $fillable = [
        'token',
        'type',
        'meta',
    ];
}
