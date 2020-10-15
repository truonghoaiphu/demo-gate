<?php
/**
 * @author Tai.Nguyen
 */

namespace Katniss\Everdeen\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Katniss\Everdeen\Mail\BaseMailable;
use Katniss\Everdeen\Models\CourseSession;
use Katniss\Everdeen\Utils\Settings;
use Katniss\Everdeen\Models\SysToken;
use Katniss\Everdeen\Utils\DateTimeHelper;
use Katniss\Everdeen\Models\User;

class TeacherConfirmSessionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $session;
    protected $listCourseSession;
    protected $numberSessionToConfirm;

    public function __construct(User $user, $listNeedNotify, $numberSessionToConfirm = 0)
    {   
        $this->user = $user;
        $this->listCourseSession = $listNeedNotify;
        $this->numberSessionToConfirm = $numberSessionToConfirm;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return new BaseMailable('teacher_required_confirm_session', [
            BaseMailable::EMAIL_FROM => _k('cmd_email'),
            BaseMailable::EMAIL_FROM_NAME => _k('cmd_name'),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->shown_name,
            BaseMailable::EMAIL_SUBJECT => ' ANTOREE | ' 
            . trans('label.email_of_request_teacher_confirm_session'). ' ',
            'detailNotifyContent' => $this->listCourseSession,
            'numberSessionToConfirm' => $this->numberSessionToConfirm,
            'teacher' => $this->user,
        ], 'en');
    }
}