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
use Katniss\Everdeen\Models\CourseInform;
use Katniss\Everdeen\Utils\DateTimeHelper;
use Carbon\Carbon;

class ConfirmReportLateNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $teacherUserProfile;
    protected $courseInform;
    protected $settings;

    public function __construct(User $teacherUserProfile, CourseInform $courseInform ,Settings $settings)
    {
        $this->teacherUserProfile = $teacherUserProfile;
        $this->courseInform = $courseInform;
        $this->settings = $settings;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $course = $this->courseInform->course;

        $studentUserProfile = $course->studentUserProfile;
        $carerUserProfile = $course->carer;
        $leanedAt = $this->courseInform->session ? $this->courseInform->session->occurred_at 
                    : $this->courseInform->meta['learn_at'];

        $settings = new Settings();
        $settings->fromUser($this->teacherUserProfile->id);
        $dateTimeHelper = new DateTimeHelper($settings);

        $leanedAt = $dateTimeHelper->compound(
            'shortTime', ' ', 'shortDate', $leanedAt
        );

        $format = $dateTimeHelper->compoundFormat('shortTime', ' ', 'shortDate');

        $leanedAt = Carbon::createFromFormat($format, $leanedAt)->format('l, M d Y');

        return new BaseMailable('confirm_report_late', [
            BaseMailable::EMAIL_FROM => $carerUserProfile->email,
            BaseMailable::EMAIL_FROM_NAME => $carerUserProfile->shown_name,
            BaseMailable::EMAIL_TO => $this->teacherUserProfile->email,
            BaseMailable::EMAIL_TO_NAME => $this->teacherUserProfile->shown_name,
            BaseMailable::EMAIL_SUBJECT => '[Antoree] Delay Report | Learner '. $studentUserProfile->shown_name .' | Course #'. $course->id .' '. $course->title .' (Date: '. $leanedAt .')',
            'teacher' => $this->teacherUserProfile,
            'teacherName' => $this->teacherUserProfile->shown_name,
            'leanedAt'=> $leanedAt,
            'courseInformMeta' => $this->courseInform->meta,
        ], currentLocaleCode());
    }
}