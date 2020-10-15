<?php

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class UserCertification extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_certifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'meta_input_id',
        'files',
        'order',
    ];

    /**
     * @author ThangNguyen
     */
    public function metaInput()
    {
        return $this->belongsTo(MetaInput::class, 'meta_input_id');
    }
}
