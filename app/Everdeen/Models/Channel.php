<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2017-05-24
 * Time: 13:46
 */

namespace Katniss\Everdeen\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class Channel extends Model
{
    use UuidTrait;

    const TYPE_NOTIFICATION = 1;
    const TYPE_CONVERSATION = 2;
    const TYPE_USER_TASK = 3; // also a notification
    const TYPE_NEWLY_TEACHER = 4; // also a notification

    protected $table = 'channels';

    protected $fillable = [
        'code',
        'type',
        'source',
    ];

    protected $hidden = [
        'type',
        'source',
        'created_at',
        'updated_at',
    ];

    protected $uuids = ['code'];

    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'channels_subscribers', 'channel_id', 'user_id');
    }

    public function notify(Notification $notification)
    {
        NotificationFacade::send($this->subscribers, $notification);
    }
}