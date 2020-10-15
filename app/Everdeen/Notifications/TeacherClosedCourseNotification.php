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

class TeacherClosedCourseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $course;
    protected $causedBy;

    public function __construct(User $user, $course, $causedBy)
    {
        $this->user = $user;
        $this->course = $course;
        $this->causedBy = $causedBy;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $customerCare = $this->course->carer;
        $studentUserProfile = $this->course->studentUserProfile;
        $titleFormat = '[Antoree] Announcement: Course Completion ● Course %s';

        return (new BaseMailable('teacher_closed_course', [
            BaseMailable::EMAIL_FROM => $customerCare->email,
            BaseMailable::EMAIL_FROM_NAME => $customerCare->shown_name,
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->shown_name,
            BaseMailable::EMAIL_SUBJECT => sprintf($titleFormat, $this->course->id),
            'user_name' => $this->user->shown_name,
            'student_name' => $studentUserProfile->shown_name,
            'caused_by'  => $this->causedBy,
        ], currentLocaleCode()))->replyTo($customerCare->email, $customerCare->shown_name);
    }
}