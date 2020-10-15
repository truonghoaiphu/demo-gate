<?php
/**
 * @author Thang.Nguyen <thang.nguyen@antoree.com>
 * Date: 2017-06-24
 */

namespace Katniss\Everdeen\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Katniss\Everdeen\Models\Channel;
use Katniss\Everdeen\Models\UserTask;

class UserTaskNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $userTask;

    public function __construct(UserTask $userTask)
    {
        $this->userTask = $userTask;
    }

    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    public function toArray()
    {
        return [
            'type' => Channel::TYPE_USER_TASK,
            'task' => [
                'id' => $this->userTask->id,
                'title' => $this->userTask->title,
            ]
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