<?php
/**
 * @author  Tai.Nguyen
 */
namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class ContactIoHistory extends Model
{   
    const STATUS_CONTACT = 2;

    const TYPE_INPUT = 1;
    const TYPE_OUTPUT = 2;

    const RATIO_NULL = '-';
    
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'contact_io_history';

    protected $fillable = [
        'contact_id',
        'request_id',
        'cared_by',
        'type',
        'status',
        'occurred_at'
    ];

    public function carer()
    {
        return $this->belongsTo(User::class, 'cared_by', 'id');
    }
}
