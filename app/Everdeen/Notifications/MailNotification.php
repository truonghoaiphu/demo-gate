<?php
/**
 *@author  Tai.Nguyen
 */
namespace Katniss\Everdeen\Notifications;

use Illuminate\Bus\Queueable;
use Katniss\Everdeen\Mail\BaseMailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Katniss\Everdeen\Models\User;
use Katniss\Everdeen\Utils\Settings;

class MailNotification extends Notification implements ShouldQueue
{   
    use Queueable;

    protected $content;
    protected $path;
	protected $user;
    protected $settings;
    protected $mailTemplate;
    protected $mailSubject;
    protected $mailSubjectParams;

	public function __construct(
        User $user, 
        Settings $settings, 
        $content, 
        $path = null, 
        $mailTemplate = 'simple_notification',
        $mailSubject = 'label.notification',
        array $mailSubjectParams = []
    )
    {

        $this->user = $user;
        $this->settings = $settings;
        $this->mailTemplate = $mailTemplate;
        $this->mailSubject = $mailSubject;
        $this->content = $content;
        $this->path = $path;
        $this->mailSubjectParams = $mailSubjectParams;
    }

	public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return new BaseMailable($this->mailTemplate, [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->showName,
            BaseMailable::EMAIL_SUBJECT => '[' . $this->settings->getBaseName() . '] ' . trans($this->mailSubject, $this->mailSubjectParams),
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'content' => $this->content,
            'url' => baseUrl($this->path, [], $this->settings->getBaseUrl()),
        ], currentLocaleCode());
    }
}