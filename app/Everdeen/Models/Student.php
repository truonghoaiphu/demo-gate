<?php
/**
 * Created by: Thang.Nguyen <thang.nguyen@antoree.com>
 * Created on: 2017-06-13
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    const STATUS_NEWLY = 0;
    const STATUS_APPROVED = 1;

    const SOURCE_CMD = 1;
    const SOURCE_MARKETING_ONLINE = 2;
    const SOURCE_CONTACT_COLLECTOR = 3;
    const SOURCE_CONTACT_HOTLINE = 4;
    const SOURCE_CONTACT_CONSULT = 5; // or from other student recommend
	
    protected $table = 'students';

    protected $primaryKey = 'user_id';

    public $incrementing = false;
    
    protected $fillable = [
        'user_id',
        'created_by',
        'approved_by',
        'approved_at',
        'meta',
        'status',
        'old_id',
        'source',
    ];
	
	protected $dates = ['deleted_at'];

    public function getMetaAttribute()
    {
        if (empty($this->attributes['meta'])) {
            return [];
        }

        $meta = json_decode($this->attributes['meta'], true);
        return $meta === false ? [] : $meta;
    }

    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = json_encode(empty($value) ? [] : $value);
    }

    public function userProfile()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'student_id', 'user_id');
    }
}
