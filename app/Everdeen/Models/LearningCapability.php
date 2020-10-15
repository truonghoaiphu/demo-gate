<?php
namespace Katniss\Everdeen\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class LearningCapability extends Model
{
    protected $table = 'learning_capabilities';

    protected $fillable = [
        'topic_id',
        'name',
    ];
}