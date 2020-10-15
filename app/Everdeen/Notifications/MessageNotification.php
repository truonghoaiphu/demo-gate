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
use Katniss\Everdeen\Models\Message;

class MessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $massive;

    public function __construct(Message $message, $massive = false)
    {
        $this->message = $message;
        $this->massive = $massive;
    }

    public function via($notifiable)
    {
        return ['broadcast'];
    }

    public function toArray()
    {
        $conversation = $this->message->conversation;
        return [
            'type' => Channel::TYPE_CONVERSATION,
            'massive' => $this->massive,
            'conversation' => [
                'id' => $conversation->id,
                'name' => $conversation->name,
                'type' => $conversation->type,
                'updated_at' => $conversation->updatedAt,
                'updated_at_f' => $conversation->formattedUpdatedAt,
                'last_message' => [
                    'id' => $this->message->id,
                    'content' => $this->message->content,
                    'created_at' => $this->message->createdAt,
                    'created_at_f' => $this->message->formattedCreatedAt,
                    'user' => [
                        'id' => $this->message->user->id,
                        'shown_name' => $this->message->user->shown_name,
                        'url_avatar_thumb' => $this->message->user->url_avatar_thumb,
                    ],
                ],
                'channel' => $conversation->channel,
                'users' => [[
                    'id' => $this->message->user->id,
                    'shown_name' => $this->message->user->shown_name,
                    'url_avatar_thumb' => $this->message->user->url_avatar_thumb,
                ]],
            ],
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => $this->toArray(),
            'created_at' => date('Y-m-d H:i:s'),
            'read_at' => null,
        ]);
    }
}