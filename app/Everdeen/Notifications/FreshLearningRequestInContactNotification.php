<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2017-05-30
 * Time: 16:43
 */

namespace Katniss\Everdeen\Notifications;

use Katniss\Everdeen\Mail\BaseMailable;

class FreshLearningRequestInContactNotification extends SimpleNotification
{
    protected $user;
    protected $settings;

    public function __construct($user, $settings, $content, $path = null)
    {
        parent::__construct($content, $path);

        $this->user = $user;
        $this->settings = $settings;
    }

    public function via($notifiable)
    {
        return array_merge(parent::via($notifiable), [
            'mail',
        ]);
    }

    public function toMail($notifiable)
    {
        return new BaseMailable('fresh_learning_request_in_contact', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->shownName,
            BaseMailable::EMAIL_SUBJECT => '[' . $this->settings->getBaseName() . '] ' . trans('label.email_of_notification'),
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'content' => $this->content,
            'url' => baseUrl($this->path, [], $this->settings->getBaseUrl()),
        ], $this->user->settings->locale);
    }
}