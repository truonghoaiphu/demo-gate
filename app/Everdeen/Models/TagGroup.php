<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class TagGroup extends Model
{
    const TEACHER_TYPE = 1;

    protected $table = 'tag_groups';

    protected $fillable = [
        'name'
    ];
}
