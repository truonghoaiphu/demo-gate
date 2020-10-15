<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2017-04-30
 * Time: 11:40
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingFieldTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'working_field_translations';

    protected $fillable = [
        'name',
        'description',
    ];
}