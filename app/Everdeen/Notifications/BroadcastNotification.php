<?php
/**
 * Created by PhpStorm.
 * User: Tran Ngọc Hiếu
 * Date: 2017-08-08
 */

namespace Katniss\Everdeen\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Katniss\Everdeen\Mail\BaseMailable;
use Katniss\Everdeen\Models\User;
use Katniss\Everdeen\Utils\Settings;

class BroadcastNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $sender;
    protected $receiver;
    protected $content;
    protected $settings;
    protected $template;
    protected $title;

    public function __construct(User $sender, User $receiver, $title, $content, $template, Settings $settings)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->content = $content;
        $this->settings = $settings;
        $this->template = $template;
        $this->title = $title;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return new BaseMailable($this->template, [
            BaseMailable::EMAIL_FROM => $this->sender->email,
            BaseMailable::EMAIL_FROM_NAME => $this->sender->shown_name,
            BaseMailable::EMAIL_TO => $this->receiver->email,
            BaseMailable::EMAIL_TO_NAME => $this->receiver->shown_name,
            BaseMailable::EMAIL_SUBJECT => $this->title,
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'receiver_name' => $this->receiver->shown_name,
            'content' => $this->content,
        ], currentLocaleCode());
    }
}