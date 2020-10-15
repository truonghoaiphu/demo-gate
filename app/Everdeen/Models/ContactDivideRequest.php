<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;

class ContactDivideRequest extends Model
{
	const STATUS_NEWLY = 1;
	const STATUS_ACCEPTED = 2;
	const STATUS_REJECTED = 3;

    protected $table = 'contact_divide_requests';

    protected $fillable = [
        'contact_id',
        'requested_by',
        'requested_to',
        'response_at',
        'status',    
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function requestedTo()
    {
        return $this->belongsTo(User::class, 'requested_to');
    }
}
