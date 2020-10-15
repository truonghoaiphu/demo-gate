<?php
/**
 * @author  Tai.Nguyen
 * @since  2017-06-30
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'tag_translations';

    protected $fillable = [
        'name',
        'description',
    ];
}