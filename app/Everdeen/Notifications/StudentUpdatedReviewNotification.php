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
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentUpdatedReviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $review;
    protected $oldReviewText;
    protected $settings;
    protected $content;
    protected $params;
    protected $cmdEmail;
    protected $hourNum;
    protected $publishDate;
    protected $oldDetails;

    public function __construct(Review $review, 
    $oldReviewText = null ,
    Settings $settings, 
    $content = '', 
    $params = null, 
    $cmdEmail = null, 
    $hourNum = null, 
    $publishDate = null, 
    array $oldDetails = [])
    {
        $this->review = $review;
        $this->oldReviewText = $oldReviewText;
        $this->settings = $settings;
        $this->content = $content;
        $this->params = $params;
        $this->cmdEmail = $cmdEmail;
        $this->hourNum = $hourNum;
        $this->publishDate = $publishDate;
        $this->oldDetails = $oldDetails;
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
            'lang_key' => 'studentUpdateReview',
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
        // course review
        $courseAvgRate = $course->reviews()
            ->where('type', '=', Review::REVIEW_COURSE_TEACHER)
            ->whereIn('status', [Review::STATUS_PUBLIC, Review::STATUS_EDITABLE])
            ->where('avg_rate', '>', 0)
            ->avg('avg_rate');

        $courseAvgRate = NumberFormatHelper::getInstance()->format($courseAvgRate);
        // teacher will receive this email
        $teacherUserProfile = $course->teacher->userProfile;
        $studentUserProfile = $course->student->userProfile;

        $mailSubject = trans('label.noti_update_review_from_student', [
            'avg_rate' => $this->review->avg_rate,
            'studentName' => $studentUserProfile->shownName,
            'courseId' => $course->id,
            'courseName' => $course->title,
        ]);

        $reviewDetails = $this->review->details->toArray();
        $oldReviewDetails = $this->oldDetails;
        $listDetail = [];
        $oldListDetail = [];

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

        foreach ($oldReviewDetails as $detail) {
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
            array_push($oldListDetail, $detail);
        }

        $baseMail = new BaseMailable('student_change_review_notification', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $teacherUserProfile->email,
            BaseMailable::EMAIL_TO_NAME => $teacherUserProfile->shownName,
            BaseMailable::EMAIL_SUBJECT => $mailSubject,
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'content' => $this->content,
            'review' => $this->review,
            'oldReviewText' => $this->oldReviewText,
            'hourNum'=> $this->hourNum,
            'course' => $course,
            'studentName' => $studentUserProfile->shownName,
            'teacherName' => $teacherUserProfile->shownName,
            'reviewDetails' => $listDetail,
            'oldReviewDetails' => $oldListDetail,
            'courseAvgRate' => $courseAvgRate,
            'publishDate' => $this->publishDate,
            'courseUrl' => baseUrl('teaching-course/{id}/rating-review',[
                'id' => $course->id
            ], $this->settings->getBaseUrl()),
        ], currentLocaleCode());

        if($this->cmdEmail)
        {
            $baseMail->bcc($this->cmdEmail, $name = null);
        }

        return $baseMail;
    }
}