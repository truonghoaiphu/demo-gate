<?php
/**
 * @author  Tai.Nguyen
 * @since  2017-06-30
 */

namespace Katniss\Everdeen\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Translatable;

    const TAG_KID_ID = 1;
    const TAG_WORK_ID = 2;
    const TAG_B2B_ID = 3;

    protected $table = 'tags';

    protected $fillable = [
        'color',
        'slug',
        'name',
        'description',
    ];

    protected $translationForeignKey = 'tag_id';
    public $translatedAttributes = [
        'name',
        'description',
    ];
    public $useTranslationFallback = true;

    public function groups()
    {
        return $this->belongsToMany(TagGroup::class, 'tags_groups', 'tag_id', 'group_id');
    }
}
