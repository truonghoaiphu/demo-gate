<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2017-04-30
 * Time: 11:24
 */

namespace Katniss\Everdeen\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class MetaInput extends Model
{
    const TYPE_CERTIFICATE_DEF = 3;

    protected $table = 'meta_inputs';

    protected $fillable = [
        'name',
        'description',
        'order',
        'type',
    ];
}