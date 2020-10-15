<?php
/**
 * @author  Tai.Nguyen <tai.nguyen@antoree.com>
 * @since  2017-06-05
 */

namespace Katniss\Everdeen\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class SpecialistTraining extends Model
{
    use Translatable;

    protected $table = 'specialist_trainings';

    protected $fillable = [
        'name',
        'description',
    ];

    protected $translationForeignKey = 'training_id';
    public $translatedAttributes = [
        'name',
        'description',
    ];
    public $useTranslationFallback = true;
}
