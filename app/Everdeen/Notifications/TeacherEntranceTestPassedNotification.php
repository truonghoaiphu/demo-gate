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

class TeacherEntranceTestPassedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $settings;
    protected $teacherGroup;

    public function __construct(User $user, $teacherGroup, Settings $settings)
    {   
        $this->user = $user;
        $this->teacherGroup = $teacherGroup;
        $this->settings = $settings;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return new BaseMailable('teacher_personal_training', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->shown_name,
            BaseMailable::EMAIL_SUBJECT => ' ANTOREE | ' . ($this->teacherGroup ? ($this->teacherGroup['name'] . ' | ') : '') . ($this->user->nationality ? ($this->user->nationality->name . ' | ') : '') . trans('label.email_of_personal_training'),
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'email' => $this->user->email,
            'shown_name' => $this->user->shown_name,
            'url_personal_training' => baseUrl('teacher-personal', [], $this->settings->getBaseUrl()),
        ], currentLocaleCode());
    }
}