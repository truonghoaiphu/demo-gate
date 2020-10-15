<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class CountryState extends Model
{
    protected $table = 'country_states';

    protected $fillable = [
        'country_id',
        'name',
    ];

    /**
     * Returns the country that belongs to this entry.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
