<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2017-05-30
 * Time: 16:43
 */

namespace Katniss\Everdeen\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Katniss\Everdeen\Models\Channel;

class SimpleNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $content;
    protected $path;
    protected $notiType;
    protected $langKey;
    protected $notiParams;
    protected $senderId;

    public function __construct(
        $content,
        $path = null,
        $notiType = null,
        $langKey = null,
        $notiParams = null,
        $senderId = null
    ) {
        $this->content = $content;
        $this->path = $path;
        $this->notiType = $notiType;
        $this->langKey = $langKey;
        $this->notiParams = $notiParams;
        $this->senderId = $senderId;
    }

    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    public function toArray()
    {   
        return [
            'type' => $this->notiType ? $this->notiType : Channel::TYPE_NOTIFICATION,
            'content' => $this->content,
            'path' => $this->path,
            'lang_key' => $this->langKey,
            'params' => $this->notiParams,
            'sender_id' => $this->senderId,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'data' => $this->toArray(),
            'created_at' => date('Y-m-d H:i:s'),
            'read_at' => null,
        ]);
    }
}