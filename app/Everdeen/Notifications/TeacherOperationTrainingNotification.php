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
use Katniss\Everdeen\Models\Teacher;
use Katniss\Everdeen\Utils\Settings;

class TeacherOperationTrainingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $settings;
    protected $teacherGroup;

    public function __construct(User $user, $teacherGroup, Settings $settings)
    {   
        $this->user = $user;
        $this->settings = $settings;
        $this->teacherGroup = $teacherGroup;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return new BaseMailable('teacher_operation_training', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->shown_name,
            BaseMailable::EMAIL_SUBJECT => ' ANTOREE | ' . ($this->teacherGroup ? ($this->teacherGroup['name'] . ' | ') : '') . ($this->user->nationality ? ($this->user->nationality->name . ' | ') : '') . trans('label.email_of_operation_training_video_session'),
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'email' => $this->user->email,
            'shown_name' => $this->user->shown_name,
            'url_operation_training_video' =>  urlOperationTrainingVideo(),
            'url_onboaring_test' =>  urlOnBoardingTest(),
            'url_conduct_demo_class' =>  urlConductDemoClass(),
            'url_teacher_faq' =>  urlTeacherFaq(),
            'url_teacher_help' =>  urlTeacherHelp(),
        ], currentLocaleCode());
    }
}