<?php
/**
 * @author Thang.Nguyen
 * @since 20/9/2017
 */

namespace Katniss\Everdeen\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Katniss\Everdeen\Mail\BaseMailable;
use Katniss\Everdeen\Models\Review;
use Katniss\Everdeen\Utils\Settings;
use Katniss\Everdeen\Models\SysToken;
use Katniss\Everdeen\Utils\DateTimeHelper;
use Katniss\Everdeen\Utils\NumberFormatHelper;
use Katniss\Everdeen\Models\Channel;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewFeedbackAddedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $review;
    protected $settings;
    protected $content;
    protected $params;
    protected $langKey;

    public function __construct(Review $review, Settings $settings, $content = '', $langKey = null, $params = null)
    {
        $this->review = $review;
        $this->settings = $settings;
        $this->content = $content;
        $this->params = $params;
        $this->langKey = $langKey;
    }

    public function via($notifiable)
    {
        return ['mail', 'broadcast', 'database'];
    }

    public function toArray()
    {
        $course = $this->review->courses->first();

        if ($course) {
            $path = baseUrl('teaching-course/{id}/rating-review',[
                'id' => $course->id
            ], $this->settings->getBaseUrl());
        } else {
            $path = '';
        }

        return [
            'type' => Channel::TYPE_SENDER,
            'content' => $this->content,
            'path' => $path,
            'sender_id' => $this->review->reviewer_id,
            'params' => $this->params,
            'lang_key' => $this->langKey,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'data' => $this->toArray(),
            'created_at' => date('Y-m-d H:i:s'),
            'read_at' => null,
        ]);
    }

    public function toMail($notifiable)
    {
        if (!$this->review->courses) {
            return false;
        }

        $course = $this->review->courses->first();
    
        // teacher will receive this email
        $teacherUserProfile = $course->teacher->userProfile;
        $studentUserProfile = $course->student->userProfile;
        $reviewer = $this->review->reviewer;
        
        if ($reviewer->id == $teacherUserProfile->id) {
            $mailSubject = trans('label.new_feedback_from_teacher', [
                'reviewerName' => $teacherUserProfile->shownName,
                'courseId' => $course->id,
                'courseName' => $course->title,
            ]);

            $fromLearner = false;
            $fromTeacher = true;
            $mailTo = $studentUserProfile;
        } else if ($reviewer->id == $studentUserProfile->id) {
            $mailSubject = trans('label.new_feedback_from_student', [
                'reviewerName' => $studentUserProfile->shownName,
                'courseId' => $course->id,
                'courseName' => $course->title,
            ]);

            $fromLearner = true;
            $fromTeacher = false;
            $mailTo = $teacherUserProfile;
        } else {
            return false;
        }

        $detail = $this->review->details->first()->toArray();

        return new BaseMailable('new_feedback_added_notification', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $mailTo->email,
            BaseMailable::EMAIL_TO_NAME => $mailTo->shownName,
            BaseMailable::EMAIL_SUBJECT => $mailSubject,
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'content' => $this->content,
            'review' => $this->review,
            'course' => $course,
            'reviewer' => $reviewer,
            'reviewDetail' => $detail,
            'courseUrl' => baseUrl('teaching-course/{id}/rating-review',[
                'id' => $course->id
            ], $this->settings->getBaseUrl()),
            'fromLearner' => $fromLearner,
            'fromTeacher' => $fromTeacher,
        ], currentLocaleCode());
    }
}