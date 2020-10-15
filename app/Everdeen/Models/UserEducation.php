<?php
/**
 * @author Thang.Nguyen
 */
namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class UserEducation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_educations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'school',
        'field',
        'description',
        'files', //[{"name":"file1_name","type":"file1_type","url":"file1_url"},...]
        'start',
        'end',
        'current',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFilesAttribute()
    {
        if (empty($this->attributes['files'])) {
            return [];
        }

        $files = json_decode($this->attributes['files'], true);
        return $files === false ? [] : $files;
    }
}
