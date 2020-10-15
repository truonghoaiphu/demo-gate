<?php
/**
 * @author Thang.Nguyen
 */

namespace Katniss\Everdeen\Notifications;


use Katniss\Everdeen\Mail\BaseMailable;

class RequestAbsenceNotificationWithMail extends SimpleNotificationWithMail
{
    protected $courseDetail;
    protected $sessionDetail;
    protected $participant;

	public function __construct(
        $user, 
        $settings, 
        $content, 
        $participant,
        $path = null,
        $mailTemplate = 'simple_notification',
        $mailSubject = 'label.notification',
        $courseDetail = [],
   		$sessionDetail = [],
        $notiType = null,
        $langKey = null,
        $notiParams = null,
        $senderId = null
    ) {
        parent::__construct($user, $settings, $content, $path, $mailTemplate, $mailSubject, $notiType, $langKey, $notiParams, $senderId);

        $this->participant = $participant;
        $this->courseDetail = $courseDetail;
        $this->sessionDetail = $sessionDetail;
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
            'participant' => $this->participant,
            'courseDetail' => $this->courseDetail,
            'sessionDetail' => $this->sessionDetail,
            'url' => baseUrl($this->path, [], $this->settings->getBaseUrl()),
        ], currentLocaleCode());
    }
}
