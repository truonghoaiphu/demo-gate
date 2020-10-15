<?php

/**
 * @author Tran Ngoc Hieu.
 * Date: 2017-06-21
 * Time: 10:40
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;
use Katniss\Everdeen\Utils\NumberFormatHelper;

class LearningRequestPayment extends Model
{   
    const DEFAULT_CURRENCY = 'VND';

    const CONFIRMED_BY_MANAGER_TRUE = 1;

    const LIST_BANK = [
        'VCB' => 'Vietcombank',
        'BIDV'=> 'BIDV',
    ];

    const TRANSFER_TYPES = [
        1 => 'Bank',
        2 => 'Cash',
        3 => 'POS',
        4 => 'Payment gate way',
    ];

    protected $table = 'learning_request_payments';
    protected $fillable = [
        'id',
        'request_id',
        'cared_by',
        'created_by',
        'amount',
        'currency',
        'code',
        'bank',
        'transfer_type',
        'transfer_content',
        'note',
        'confirmed_by_manager',
    ];


    public function request()
    {
        return $this->belongsTo(LearningRequest::class, 'request_id', 'id');
    }

    public function carer()
    {
        return $this->belongsTo(User::class, 'cared_by', 'id');
    }

    public function getFormattedAmountAttribute()
    {
        return NumberFormatHelper::getInstance()
            ->formatCurrency($this->attributes['amount'], $this->attributes['currency']);
    }

    public function getFormattedBankAttribute()
    {
        return array_key_exists($this->attributes['bank'], LearningRequestPayment::LIST_BANK) ? LearningRequestPayment::LIST_BANK[$this->attributes['bank']] : '';
    }

    public function getFormattedTransferTypeAttribute()
    {
        return array_key_exists($this->attributes['transfer_type'], LearningRequestPayment::TRANSFER_TYPES) ? LearningRequestPayment::TRANSFER_TYPES[$this->attributes['transfer_type']] : '';
    }

    public function getFormattedCreatedAtAttribute()
    {
        return DateTimeHelper::getInstance()
            ->compound('shortDate', ' ', 'longTime', $this->attributes['created_at']);
    }
}