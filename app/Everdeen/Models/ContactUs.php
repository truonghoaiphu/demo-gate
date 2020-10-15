<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Broadcasting\Channel as BroadcastingChannel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Katniss\Everdeen\Notifications\ContactUsNotification;
use Katniss\Everdeen\Notifications\BroadcastNotification;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Notifications\ResetPassword as ResetPasswordNotification;
use Katniss\Everdeen\Vendors\Zizaco\Entrust\Traits\EntrustUserTrait as OverriddenEntrustUserTrait;
use Katniss\Everdeen\Utils\DateTimeHelper;
use Laravel\Passport\HasApiTokens;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class ContactUs extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $table = 'contact_us';
    
    /**
        * The attributes that are mass assignable.
        *
        * @var array
        */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'message',
    ];
    
    public function sendMail()
    {
        $this->notify(new ContactUsNotification($this, settings()));
    }
}