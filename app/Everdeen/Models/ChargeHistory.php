<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeHistory extends Model
{
    protected $table = 'charge_history';

    protected $fillable = [
        'user_id',
        'email',
        'name',
        'phone',
        'token',
        'amount',
        'amount_currency',
        'message',
        'response',
        'customer_meta',
        'card_meta',
        'charge_meta',
        'step',
        'created_at',
        'updated_at',
    ];

    public function setCustomerMetaAttribute($value)
    {
        $this->attributes['customer_meta'] = empty($value) ? json_encode([]) : json_encode($value);
    }

    public function getCustomerMetaAttribute()
    {
        if (empty($this->attributes['customer_meta'])) return [];

        $customerMeta = json_decode($this->attributes['customer_meta'], true);
        return $customerMeta !== false ? $customerMeta : [];
    }

    public function setChargeMetaAttribute($value)
    {
        $this->attributes['charge_meta'] = empty($value) ? json_encode([]) : json_encode($value);
    }

    public function getChargeMetaAttribute()
    {
        if (empty($this->attributes['charge_meta'])) return [];

        $chargeMeta = json_decode($this->attributes['charge_meta'], true);
        return $chargeMeta !== false ? $chargeMeta : [];
    }

    public function setCardMetaAttribute($value)
    {
        $this->attributes['card_meta'] = empty($value) ? json_encode([]) : json_encode($value);
    }

    public function getCardMetaAttribute()
    {
        if (empty($this->attributes['card_meta'])) return [];

        $cardMeta = json_decode($this->attributes['card_meta'], true);
        return $cardMeta !== false ? $cardMeta : [];
    }
}
