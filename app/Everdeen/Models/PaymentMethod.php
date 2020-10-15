<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;


class PaymentMethod extends Model
{
    protected $table = 'payment_methods';

    protected $fillable = [
        'payment_method',
        'created_at',
        'updated_at',
    ];

    /**
     * Returns the country that belongs to this entry.
     */

}
