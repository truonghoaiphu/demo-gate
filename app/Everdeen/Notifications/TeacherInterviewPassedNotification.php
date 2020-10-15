<?php
/**
 * @author Tai.Nguyen
 */

namespace Katniss\Everdeen\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Katniss\Everdeen\Mail\BaseMailable;
use Katniss\Everdeen\Models\User;
use Katniss\Everdeen\Utils\Settings;

class TeacherInterviewPassedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $settings;
    protected $teacherGroup;
    protected $contractUrl;

    public function __construct(User $user, $teacherGroup, $contractUrl, Settings $settings)
    {   
        $this->user = $user;
        $this->settings = $settings;
        $this->teacherGroup = $teacherGroup;
        $this->contractUrl = $contractUrl;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $mail = new BaseMailable('teacher_interview_passed', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->shown_name,
            BaseMailable::EMAIL_SUBJECT => ' ANTOREE | ' . ($this->teacherGroup ? ($this->teacherGroup['name'] . ' | ') : '') . ($this->user->nationality ? ($this->user->nationality->name . ' | ') : '') . trans('label.email_of_welcome_antoree_community'),
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'email' => $this->user->email,
            'shown_name' => $this->user->shown_name,
            'url_payment' => baseUrl('payment', [], $this->settings->getBaseUrl()),
            'url_online_library' =>  urlOnlineLibrary(),
            'url_signin_online' =>  urlSignInOnline(),
        ], currentLocaleCode());

        if ($this->contractUrl != null) {
            $mail->attach($this->contractUrl);
        }

        return $mail;
    }
}