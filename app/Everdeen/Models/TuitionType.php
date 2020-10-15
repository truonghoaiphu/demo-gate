<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class TuitionType extends Model
{
    protected $table = 'tuition_types';

    protected $fillable = [
        'tuition_type',
        'created_at',
        'updated_at',
    ];

    /**
     * Returns the country that belongs to this entry.
     */

}
