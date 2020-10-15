<?php
namespace Katniss\Everdeen\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class LearningTag extends Model
{
    protected $table = 'learning_tags';

    protected $fillable = [
        'topic_id',
        'name',
    ];
}