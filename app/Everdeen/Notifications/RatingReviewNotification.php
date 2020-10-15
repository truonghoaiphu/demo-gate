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
use Katniss\Everdeen\Models\Course;

class RatingReviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $settings;
    protected $token;
    protected $teacher;
    protected $course;

    public function __construct(User $user, Course $course, User $teacher, $token, Settings $settings)
    {   
        $this->user = $user;
        $this->settings = $settings;
        $this->course = $course;
        $this->teacher = $teacher;
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return new BaseMailable('rating_review', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->shown_name,
            BaseMailable::EMAIL_SUBJECT => trans('label.email_of_rating_review', [
                'teacherName' => $this->teacher->shown_name,
                'courseId' => $this->course->id,
                'courseName' => $this->course->title,
            ]),
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'email' => $this->user->email,
            'shown_name' => $this->user->shown_name,
            'url_rating_review' => baseUrl('rating-review?token=' . $this->token, [], $this->settings->getBaseUrl()),
            'teacher_name' =>  $this->teacher->shown_name,
            'teacher_avatar' => $this->teacher->url_avatar,
        ], currentLocaleCode());
    }
}