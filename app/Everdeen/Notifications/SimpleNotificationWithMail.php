<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2017-05-30
 * Time: 16:43
 */

namespace Katniss\Everdeen\Notifications;


use Katniss\Everdeen\Mail\BaseMailable;

class SimpleNotificationWithMail extends SimpleNotification
{
	protected $user;
    protected $settings;
    protected $mailTemplate;
    protected $mailSubject;

	public function __construct(
        $user, 
        $settings, 
        $content, 
        $path = null, 
        $mailTemplate = 'simple_notification',
        $mailSubject = 'label.notification',
        $notiType = null,
        $langKey = null,
        $notiParams = null,
        $senderId = null
    ) {
        parent::__construct($content, $path, $notiType, $langKey, $notiParams, $senderId);

        $this->user = $user;
        $this->settings = $settings;
        $this->mailTemplate = $mailTemplate;
        $this->mailSubject = $mailSubject;
    }

	public function via($notifiable)
    {
        return array_merge(['mail'], parent::via($notifiable));
    }

    public function toMail($notifiable)
    {
        return new BaseMailable($this->mailTemplate, [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->showName,
            BaseMailable::EMAIL_SUBJECT => '[' . $this->settings->getBaseName() . '] ' . trans($this->mailSubject),
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'content' => $this->content,
            'url' => baseUrl($this->path, [], $this->settings->getBaseUrl()),
        ], currentLocaleCode());
    }
}