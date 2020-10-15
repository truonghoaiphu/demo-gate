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
use Katniss\Everdeen\Models\Course;
use Katniss\Everdeen\Utils\Settings;
use Katniss\Everdeen\Models\SysToken;
use Katniss\Everdeen\Utils\DateTimeHelper;
use Katniss\Everdeen\Utils\NumberFormatHelper;
use Katniss\Everdeen\Models\Channel;
use Illuminate\Notifications\Messages\BroadcastMessage;

class StudentDeletedReviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $course;
    protected $review;
    protected $settings;
    protected $content;
    protected $params;
    protected $cmdEmail;
    protected $hourNum;
    protected $details;

    public function __construct(
        Course $course, 
        array $review, 
        Settings $settings, 
        $content = '', 
        $params = null, 
        $cmdEmail = null, 
        $hourNum = null,
        $details = null
    )
    {
        $this->course = $course;
        $this->review = $review;
        $this->settings = $settings;
        $this->content = $content;
        $this->params = $params;
        $this->cmdEmail = $cmdEmail;
        $this->hourNum = $hourNum;
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['mail', 'broadcast', 'database'];
    }

    public function toArray()
    {
        if ($this->course) {
            $teacherUserProfile = $this->course->teacher->userProfile;
            $path = baseUrl('teacher/{id}',[
                'id' => $teacherUserProfile->id
            ], _k('url_commercial'));
        } else {
            $path = '';
        }

        return [
            'type' => Channel::TYPE_SENDER,
            'content' => $this->content,
            'path' => $path,
            'sender_id' => $this->review['reviewer_id'],
            'params' => $this->params,
            'lang_key' => 'studentDeleteReview',
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
        if (!$this->course) {
            return false;
        }

        $reviewAvgRate = NumberFormatHelper::getInstance()->format($this->review['avg_rate']);
        // teacher will receive this email
        $teacherUserProfile = $this->course->teacher->userProfile;
        $studentUserProfile = $this->course->student->userProfile;

        $mailSubject = trans('label.delete_review_from_student', [
            'avg_rate' => $reviewAvgRate,
            'studentName' => $studentUserProfile->shownName,
            'courseId' => $this->course->id,
            'courseName' => $this->course->title,
        ]);

        $reviewDetails = $this->details;
        $listDetail = [];

        foreach ($reviewDetails as $detail) {
            if ($detail['detail_id'] == Review::RATE_REFER_FRIEND
                || $detail['detail_id'] == Review::RATE_NETWORK_QUALITY
                || $detail['detail_id'] == Review::RATE_USEFUL) {
                continue;
            }

            switch ($detail['detail_id']) {
                case Review::RATE_CURRICULUM_CONTENT:
                    $detail['critical_name'] = trans('label.course_rating_curriculum_content');
                    break;
                case Review::RATE_TEACHING_METHOD:
                    $detail['critical_name'] = trans('label.course_rating_teaching_methods');
                    break;
                case Review::RATE_ATTITUDE:
                    $detail['critical_name'] = trans('label.course_rating_attitude');
                    break;
                case Review::RATE_SATISFACTION:
                    $detail['critical_name'] = trans('label.course_rating_satisfaction');
                    break;
            }

            array_push($listDetail, $detail);
        }

        $baseMail = new BaseMailable('student_delete_review_notification', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $teacherUserProfile->email,
            BaseMailable::EMAIL_TO_NAME => $teacherUserProfile->shownName,
            BaseMailable::EMAIL_SUBJECT => $mailSubject,
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'content' => $this->content,
            'review' => $this->review,
            'course' => $this->course,
            'studentName' => $studentUserProfile->shownName,
            'teacherName' => $teacherUserProfile->shownName,
            'reviewDetails' => $listDetail,
            'reviewAvgRate' => $reviewAvgRate,
            'hourNum' => $this->hourNum,
            'teacherUrl' => baseUrl('teacher/{id}',[
                'id' => $teacherUserProfile->id
            ], _k('url_commercial')),
        ], currentLocaleCode());

        if($this->cmdEmail)
        {
            $baseMail->bcc($this->cmdEmail, $name = null);
        }

        return $baseMail;
    }
}