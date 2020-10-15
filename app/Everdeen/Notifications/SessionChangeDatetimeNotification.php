<?php
/**
 * @author Thang.Nguyen
 */

namespace Katniss\Everdeen\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Katniss\Everdeen\Mail\BaseMailable;
use Katniss\Everdeen\Models\CourseSession;
use Katniss\Everdeen\Utils\Settings;
use Katniss\Everdeen\Utils\DateTimeHelper;
use Katniss\Everdeen\Models\SysToken;

class SessionChangeDatetimeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $session;
    protected $settings;
    protected $content;
    protected $oldOccurred;
    protected $oldDuration;
    protected $changeToken;

    public function __construct(
        CourseSession $session, 
        Settings $settings,
        $oldOccurred,
        $oldDuration,
        $content = '',
        $changeToken = false
    ) {
        $this->session = $session;
        $this->settings = $settings;
        $this->content = $content;
        $this->oldOccurred = $oldOccurred;
        $this->oldDuration = $oldDuration;
        $this->changeToken = $changeToken;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $key = str_random(128);
        $token = SysToken::where('meta', '=', $this->session->id)
        ->where('type', '=', SysToken::TYPE_CONFIRM_SESSION)->first();
        if($token)
        {
            if($this->changeToken){
                $token->token = $key;
                $token->save();
            } else 
            {
                $key = $token->token;
            }
        }
        else {
            $token = SysToken::create([
                'token' => $key,
                'type' => SysToken::TYPE_CONFIRM_SESSION,
                'meta' => $this->session->id,
            ]);
        }

        $course = $this->session->course;

        $studentUserProfile = $course->student->userProfile;
        $teacherUserProfile = $course->teacher->userProfile;
        
        $settings = new Settings();
        $settings->fromUser($studentUserProfile->id);
        $dateTimeHelper = new DateTimeHelper($settings);
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

        $stringUrlInvite = "https://docs.google.com/forms/d/e/1FAIpQLSfWvbYCQDh3ZL47xVTWKbOk-cktvryASg8apvuyDsplRTucXA/viewform?usp=pp_url&entry.559352220=%s&entry.362115131=%s&entry.1933406802=%s&entry.1842448193&entry.1009741461";
        

        $carer = $course->carer;

        $baseMail = new BaseMailable('session_change_datetime', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $studentUserProfile->email,
            BaseMailable::EMAIL_TO_NAME => $studentUserProfile->display_name,
            BaseMailable::EMAIL_SUBJECT => '[' . $this->settings->getBaseName() . '] ' 
                . 'Antoree - Xác nhận thay đổi thời gian và nội dung bài học ngày '
                . $dateTimeHelper->shortDate($this->session->original_time),
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'email' => $studentUserProfile->email,
            'url_confirm' => baseUrl('course/{id}/session/{session_id}/confirm?student_id=' . $studentUserProfile->id . '&token=' . $key, [
                'id' => $this->session->course->id,
                'session_id' => $this->session->id,
            ], $this->settings->getBaseUrl()),
            'url_invite' => sprintf($stringUrlInvite, $studentUserProfile->shown_name, $studentUserProfile->phone_number, $studentUserProfile->email),
            'student' => $studentUserProfile,
            'teacher' => $teacherUserProfile,
            'course' => $course,
            'newOccurred' => $dateTimeHelper->compound('shortTime', ' ', 'shortDate', $this->session->occurred_at),
            'oldOccurred' => $dateTimeHelper->compound('shortTime', ' ', 'shortDate', $this->oldOccurred),
            'oldDuration' => $this->oldDuration,
            'session' => $this->session,
            'content' => $this->content,
            'remainingDuration' => $remainingDuration,
            'remainingDurationWithUpdate' => $remainingDurationWithUpdate,
            'sessionIsPenalty' => $sessionIsPenalty,
        ], currentLocaleCode());

        if($carer && $carer->email)
        {
            $baseMail->bcc($carer->email, $name = null);
        }

        return $baseMail;
    }
}