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

class TeacherRegisterNotification extends Notification implements ShouldQueue
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
        return new BaseMailable('welcome_teacher', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->shown_name,
            BaseMailable::EMAIL_SUBJECT => ' ANTOREE | ' . ($this->teacherGroup ? ($this->teacherGroup['name'] . ' | ') : '') . ($this->user->nationality ? ($this->user->nationality->name . ' | ') : '') . trans('label.email_of_recruitment_invitation'),
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'email' => $this->user->email,
            'teacher_group' => $this->teacherGroup,
            'shown_name' => $this->user->shown_name,
            'email_verified' => $this->user->email_verified,
            'url_activate' => baseUrl('verify-email/{id}/{verification_code}', [
                'id' => $this->user->id,
                'verification_code' => $this->user->verification_code,
            ], $this->settings->getBaseUrl()),
            'url_setup_profile' => baseUrl('setup', [], $this->settings->getBaseUrl()),
            'url_entrance_test' => urlEntranceTest()['1'],
        ], currentLocaleCode());
    }
}