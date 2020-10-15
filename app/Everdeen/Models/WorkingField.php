<?php

namespace Katniss\Everdeen\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class WorkingField extends Model
{
    use Translatable;

    protected $table = 'working_fields';

    protected $fillable = [
        'name',
        'description',
    ];

    protected $translationForeignKey = 'field_id';
    public $translatedAttributes = [
        'name',
        'description',
    ];
    public $useTranslationFallback = true;
}
