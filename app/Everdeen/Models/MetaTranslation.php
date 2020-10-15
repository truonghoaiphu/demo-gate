<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2017-04-30
 * Time: 11:40
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class MetaTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'meta_translations';

    protected $fillable = [
        'name',
        'description',
    ];
}