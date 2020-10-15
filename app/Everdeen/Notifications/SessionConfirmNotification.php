<?php
/**
 * @author Thang.Nguyen
 * @since 3/8/2017
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

class SessionConfirmNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $session;
    protected $settings;
    protected $content;

    public function __construct(CourseSession $session, Settings $settings, $content = '')
    {
        $this->session = $session;
        $this->settings = $settings;
        $this->content = $content;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $course = $this->session->course;
        $studentUserProfile = $course->student->userProfile;
        $teacherUserProfile = $course->teacher->userProfile;

        // calculate remaining hours
        $totalStudyDuration = $course->passed_duration + $course->passed_bonus_duration + $course->passed_penalty_duration;
        $totalDuration = $course->duration + $course->bonus_duration + $course->penalty_duration;

        $remainingDuration = $totalDuration - $totalStudyDuration;
        // update remaining with new course
        $remainingDurationWithUpdate = $remainingDuration;

        if ($this->session->type == CourseSession::TYPE_PENALTY) {
            $sessionIsPenalty = true;
        } elseif ($this->session->type == CourseSession::TYPE_NORMAL
            || $this->session->type == CourseSession::TYPE_MAKEUP
            || $this->session->type == CourseSession::TYPE_BONUS
        ) {
            $sessionIsPenalty = false;
            $remainingDurationWithUpdate -= $this->session->duration;
        }

        $key = str_random(128);
        $token = SysToken::create([
            'token' => $key,
            'type' => SysToken::TYPE_CONFIRM_SESSION,
            'meta' => $this->session->id,
        ]);

        $settings = new Settings();
        $settings->fromUser($studentUserProfile->id);
        $dateTimeHelper = new DateTimeHelper($settings);

        $stringUrlInvite = "https://docs.google.com/forms/d/e/1FAIpQLSfWvbYCQDh3ZL47xVTWKbOk-cktvryASg8apvuyDsplRTucXA/viewform?usp=pp_url&entry.559352220=%s&entry.362115131=%s&entry.1933406802=%s&entry.1842448193&entry.1009741461";
        
        return new BaseMailable('session_confirmation', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $studentUserProfile->email,
            BaseMailable::EMAIL_TO_NAME => $studentUserProfile->display_name,
            BaseMailable::EMAIL_SUBJECT => '[' . $this->settings->getBaseName() . '] ' 
                . 'Antoree - Xác nhận thời gian và nội dung bài học ngày '
                . $dateTimeHelper->shortDate($this->session->original_time),
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'email' => $studentUserProfile->email,
            'url_confirm' => baseUrl('course/{id}/session/{session_id}/confirm?student_id=' . $studentUserProfile->id . '&token=' . $key, [
                'id' => $this->session->course->id,
                'session_id' => $this->session->id,
            ], $this->settings->getBaseUrl()),
            'url_invite' => sprintf($stringUrlInvite, $studentUserProfile->shown_name, $studentUserProfile->phone_number, $studentUserProfile->email),
            'session' => $this->session,
            'occurredAt' => $dateTimeHelper->compound('shortTime', '  ', 'shortDate', $this->session->occurred_at),
            'student' => $studentUserProfile,
            'teacher' => $teacherUserProfile,
            'course' => $course,
            'remainingDuration' => $remainingDuration,
            'remainingDurationWithUpdate' => $remainingDurationWithUpdate,
            'sessionIsPenalty' => $sessionIsPenalty,
            'content' => $this->content,
        ], currentLocaleCode());
    }
}