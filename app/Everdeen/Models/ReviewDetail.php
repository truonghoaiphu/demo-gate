<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Katniss\Everdeen\Utils\DateTimeHelper;

class ReviewDetail extends Model
{
	public $timestamps = false;
	
    protected $table = 'review_details';

    protected $fillable = [
        'review_id',
        'detail_id',
        'value',
        'max_rate',
    ];
}
