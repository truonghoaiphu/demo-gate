<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherGroup extends Model
{
    const TYPE_COUNTRY = 1;
    const GROUP_VIETNAM = 1;
    const GROUP_PHILIPINES = 2;
    const GROUP_NATIVE = 3;

    protected $table = 'teacher_groups';

    protected $fillable = [
        'name',
        'value',
        'type',
    ];

    public function getValueAttribute()
    {
    	if (empty($this->attributes['value'])) {
            return [];
        }

        $value = explode(',', $this->attributes['value']);
        return $value === false ? [] : $value;
    }
}
