<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    protected $fillable = [
        'country_id',
        'country_state_id',
        'name',
    ];
}
