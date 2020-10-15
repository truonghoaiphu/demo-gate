<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
	const TYPE_CURRICULUM = 1;
	const TYPE_UNIT = 2;
	const TYPE_LESSON = 3;

    protected $table = 'curricula';

    protected $fillable = [
        'created_by',
        'parent_id',
        'title',
        'description',
        'links', // [{"title":"title_1", url": "url_1"}]
        'attachments',//[{"name":"file1_name","type":"file1_type","url":"file1_url"},...]
        'duration',
        'type',
        'order',
    ];

    public function setLinksAttribute($value)
    {
        $this->attributes['links'] = json_encode(empty($value) ? [] : $value);
    }

    public function getLinksAttribute()
    {
        if (empty($this->attributes['links'])) {
            return [];
        }

        $links = json_decode($this->attributes['links'], true);

        return $links === false ? [] : $links;    
    }

    public function getAttachmentsAttribute()
    {
        if (empty($this->attributes['attachments'])) {
            return [];
        }

        $attachments = json_decode($this->attributes['attachments'], true);
        
        return $attachments === false ? [] : $attachments;    
    }

    public function setAttachmentsAttribute($value)
    {
        $this->attributes['attachments'] = json_encode(empty($value) ? [] : $value);
    }

    public function parent()
    {
        return $this->belongsTo('Katniss\Everdeen\Models\Curriculum', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Katniss\Everdeen\Models\Curriculum', 'parent_id');
    }
}
