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
use Katniss\Everdeen\Models\User;
use Katniss\Everdeen\Utils\Settings;
use Katniss\Everdeen\Models\Course;

class CourseCloseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $course;
    protected $settings;

    public function __construct(User $user, Course $course, Settings $settings)
    {
        $this->user = $user;
        $this->course = $course;
        $this->settings = $settings;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return new BaseMailable('course_close', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->display_name,
            BaseMailable::EMAIL_SUBJECT => '[Antoree] The course has learned the number of hours',
            'course' => $this->course,
            'carer'  => $this->course->carer,
            'carer_shown_name'  => $this->course->carer->shown_name,
            'url_close' => $this->settings->getBaseUrl() . '/caring-course?student_id=' . $this->course->student->user_id . '&teacher_id=' . $this->course->teacher->user_id ,
        ], currentLocaleCode());
    }
}