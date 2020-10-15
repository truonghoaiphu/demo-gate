<?php
/**
 * @author  Tai.Nguyen <tai.nguyen@antoree.com>
 * @since  201-06-05
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialistTrainingTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'specialist_training_translations';

    protected $fillable = [
        'name',
        'description',
    ];
}