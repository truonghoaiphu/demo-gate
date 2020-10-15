<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerWard extends Model
{
    protected $table = 'customer_wards';

    protected $fillable = [
        'customer_district_id',
        'name',
        'customer_city_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Returns the country that belongs to this entry.
     */

}
