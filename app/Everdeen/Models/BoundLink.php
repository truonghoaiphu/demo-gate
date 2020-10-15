<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class BoundLink extends Model
{
    protected $table = 'bound_links';

    const TYPE_ACTIVATION = 1;
    const TYPE_RESET_PASSWORD = 2;

    protected $fillable = [
        'secret',
        'ref',
        'data',
        'expired',
        'count',
        'type',
    ];

    public function getDataAttribute()
    {
        if (empty($this->attributes['data'])) {
            return [];
        }

        $meta = json_decode($this->attributes['data'], true);
        return $meta === false ? [] : $meta;
    }
}
