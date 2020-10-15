<?php

namespace Katniss\Everdeen\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class CacheContactWith90dlr extends Model
{
    protected $table = '_cache_contact_with_90dlr';

    protected $fillable = [
        'contact_id',
        'request_id',
        'count_after_days',
        'handled',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}