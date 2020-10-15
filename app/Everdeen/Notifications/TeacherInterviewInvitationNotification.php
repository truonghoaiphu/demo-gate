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

class TeacherInterviewInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $settings;
    protected $schedule;

    public function __construct(User $user, $schedule, Settings $settings)
    {   
        $this->user = $user;
        $this->settings = $settings;
        $this->schedule = $schedule;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return new BaseMailable('teacher_interview_invitation', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->shown_name,
            BaseMailable::EMAIL_SUBJECT => trans('label.email_of_interview_schedule_confirm'),
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'email' => $this->user->email,
            'shown_name' => $this->user->shown_name,
            'schedule_time' => $this->schedule['time'],
            'schedule_date' => $this->schedule['date'],
        ], currentLocaleCode());
    }
}