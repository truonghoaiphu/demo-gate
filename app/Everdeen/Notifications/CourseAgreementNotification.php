<?php
/**
 * Created by PhpStorm.
 * User: Tran Ngọc Hiếu
 * Date: 2017-08-08
 */

namespace Katniss\Everdeen\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Katniss\Everdeen\Mail\BaseMailable;
use Katniss\Everdeen\Utils\Settings;
use Katniss\Everdeen\Models\User;
use Katniss\Everdeen\Models\Course;

class CourseAgreementNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $filePath;
    protected $user;
    protected $template;
    protected $course;

    public function __construct(User $user, $filePath, $template, Course $course)
    {
        $this->filePath = $filePath;
        $this->user = $user;
        $this->course = $course;
        $this->template = $template;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $customerCare = $this->course->carer;
        $secondUser = null;
        $titleFormat = '';
        if($this->user->id == $this->course->student_id)
        {
            $secondUser = $this->course->teacherUserProfile;
            $titleFormat = '[Antoree] Course Agreement | Teacher %s | Course %s';
        } else
        {
            $secondUser = $this->course->studentUserProfile;
            $titleFormat = '[Antoree] Course Agreement | Learner %s | Course %s';
        }

        return (new BaseMailable($this->template, [
            BaseMailable::EMAIL_FROM => $customerCare->email,
            BaseMailable::EMAIL_FROM_NAME => $customerCare->shown_name,
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->shown_name,
            BaseMailable::EMAIL_SUBJECT => sprintf($titleFormat, $secondUser->shown_name, $this->course->id),
            'user_name' => $this->user->shown_name,
            'second_user_name' => $secondUser->shown_name,
            'course_duration'  => ($this->course->duration - 3),
        ], currentLocaleCode()))->attach($this->filePath, ['as' => 'CourseAgreement.pdf', 'mime' => 'application/pdf']);;
    }
}