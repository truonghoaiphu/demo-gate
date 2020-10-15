<?php
/**
 * @author Tran Ngoc Hieu.
 * Date: 2017-06-21
 * Time: 10:40
 */

namespace Katniss\Everdeen\Models;

use Illuminate\Database\Eloquent\Model;

class ContactHistory extends Model
{
    const TYPE_CREATE = 1;
    const TYPE_CONVERT = 2;
    const TYPE_CALL = 3;
    const TYPE_TEST = 4;
    const TYPE_UPDATE = 5;
    const TYPE_DIVIDE = 6;
    const TYPE_REASSIGN = 7;
    const TYPE_USER = 8;
    const TYPE_ATTACH = 9;
    const TYPE_CUSTOMER = 10;
    const TYPE_DESTROY = 11;

    const TYPE_BULK_UPDATE = 12;
    const TYPE_START_SESSION = 13;
    const TYPE_END_SESSION = 14;

    const TYPE_LEARNING_REQUEST_UPDATE = 15;
    const TYPE_LEARNING_REQUEST_DESTROY = 16;
    const TYPE_LEARNING_REQUEST_CREATE = 17;

    const TYPE_LEARNING_REQUEST_UPDATE_LEVEL = 18;

    protected $table = 'contact_history';

    protected $typeDefinition = [
        'type_create',
        'type_convert',
        'type_call',
        'type_test',
        'type_update',
        'type_divide',
        'type_reassign',
        'type_user',
        'type_attach',
        'type_customer',
        'type_destroy',
        'type_bulk_update',
        'type_start_session',
        'type_end_session',
        'type_learning_request_update',
        'type_learning_request_destroy',
        'type_learning_request_create',
        'type_learning_request_update_level',
    ];

    protected $fillable = [
        'user_id',
        'contact_id',
        'request_id',
        'type',
        'data',
        'note',
        'has_child',
        'is_temp',
        'parent_id',
        'old_id',
    ];

    public function getTypeAttribute()
    {
        $type = $this->attributes['type'];

        if ($type && intval($type) > 0) {
            return $this->typeDefinition[intval($type) - 1];
        }

        return $type;
    }

    public function getDataAttribute()
    {
        return empty($this->attributes['data']) ? [] : json_decode($this->attributes['data'], true);
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode(empty($value) ? [] : $value);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function childs()
    {
        return $this->hasMany(ContactHistory::class, 'parent_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}