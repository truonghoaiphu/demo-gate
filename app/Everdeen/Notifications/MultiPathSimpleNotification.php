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

class MultiPathSimpleNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $content;
    protected $paths;

    public function __construct($content, $paths = [])
    {
        $this->content = $content;
        $this->paths = $paths;
    }

    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    public function toArray()
    {
        return [
            'type' => Channel::TYPE_NOTIFICATION,
            'content' => $this->content,
            'paths' => $this->paths,
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