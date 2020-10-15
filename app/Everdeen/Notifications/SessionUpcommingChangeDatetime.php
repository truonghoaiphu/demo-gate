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
use Katniss\Everdeen\Models\User;

class SessionUpcommingChangeDatetime extends Notification implements ShouldQueue
{
    use Queueable;

    protected $sender;
    protected $receiver;
    protected $session;
    protected $settings;
    protected $content;
    protected $oldSessionSchedule;
    protected $cmdEmail;

    public function __construct(
        User $sender,
        User $receiver,
        CourseSession $session, 
        Settings $settings,
        $content = '',
        $oldSessionSchedule = '',
        $cmdEmail = null
    ) {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->session = $session;
        $this->settings = $settings;
        $this->content = $content;
        $this->oldSessionSchedule = $oldSessionSchedule;
        $this->cmdEmail = $cmdEmail;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $key = str_random(128);
        $token = SysToken::where('meta', '=', $this->session->id)
            ->where('type', '=', SysToken::TYPE_CHANGE_UPCOMMING_OCCUR)->first();
        
        if ($token) {
            $token->token = $key;
            $token->save();
        } else {
            $token = SysToken::create([
                'token' => $key,
                'type' => SysToken::TYPE_CHANGE_UPCOMMING_OCCUR,
                'meta' => $this->session->id,
            ]);
        }

        $course = $this->session->course;

        $studentUserProfile = $course->student->userProfile;
        $teacherUserProfile = $course->teacher->userProfile;
        
        $settings = new Settings();
        $settings->fromUser($this->receiver->id);
        $dateTimeHelper = new DateTimeHelper($settings);
        $mailTemplate = $this->getMailTemplate();
        $newSessionOccurredAt = $dateTimeHelper->compound(
            'shortTime', ' ', 'shortDate', $this->session->occurred_at
        );
        $sessionOccurredAtDate = $dateTimeHelper->shortDate($this->session->occurred_at);

        if ($this->sender->id == $course->teacher_id) {
            $mailTitle = "Thay đổi ngày giờ học của buổi học sắp đến vào ngày $sessionOccurredAtDate | GV $teacherUserProfile->shownName | Khoá học  #$course->id $course->title.";
        } elseif ($this->sender->id == $course->student_id) {
            $mailTitle = "Change Day/ Time of Upcoming session to $sessionOccurredAtDate | Learner $studentUserProfile->shownName | Course  #$course->id $course->title.";
        }

        $baseMail = new BaseMailable($mailTemplate, [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $this->receiver->email,
            BaseMailable::EMAIL_TO_NAME => $this->receiver->display_name,
            BaseMailable::EMAIL_SUBJECT => '[' . $this->settings->getBaseName() . '] ' 
                . $mailTitle,
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'email' => $this->receiver->email,
            'url_change_datetime' => baseUrl('teaching-course/{id}/session#time-{session_id}', [
                'id' => $this->session->course->id,
                'session_id' => $this->session->id,
            ], $this->settings->getBaseUrl()),
            'student' => $studentUserProfile,
            'teacher' => $teacherUserProfile,
            'course' => $course,
            'newOccurred' => $newSessionOccurredAt,
            'oldOccurred' => $this->oldSessionSchedule,
            'session' => $this->session,
            'content' => $this->content,
        ], currentLocaleCode());

        if($this->cmdEmail) {
            $baseMail->bcc($this->cmdEmail, $name = null);
        }

        return $baseMail;
    }

    protected function getMailTemplate()
    {
        $course = $this->session->course;

        if ($course->student_id == $this->sender->id) {
            return 'student_change_upcomming_session_datetime';
        } elseif ($course->teacher_id == $this->sender->id) {
            return 'teacher_change_upcomming_session_datetime';
        }
    }
}