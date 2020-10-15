<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCity extends Model
{
    protected $table = 'customer_cities';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    /**
     * Returns the country that belongs to this entry.
     */

}
