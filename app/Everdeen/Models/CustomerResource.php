<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerResource extends Model
{
    protected $table = 'customer_resources';

    protected $fillable = [
        'customer_resource',
        'created_at',
        'updated_at',
    ];

    /**
     * Returns the country that belongs to this entry.
     */

}
