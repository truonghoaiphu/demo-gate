<?php
/**
 * @author Thang.Nguyen
 */

namespace Katniss\Everdeen\Notifications;

use Katniss\Everdeen\Mail\BaseMailable;

class CourseBonusAddedNotification extends SimpleNotificationWithMail
{
    protected $courseDetail;
    protected $bonusDetail;
    protected $mailSubjectParams;

    public function __construct(
        $user,
        $settings,
        $content,
        $path = null,
        $mailTemplate = 'simple_notification',
        $mailSubject = 'label.notification',
        $mailSubjectParams = [],
        $courseDetail = [],
        $bonusDetail = [],
        $notiType = null,
        $langKey = null,
        $notiParams = null
    ) {
        parent::__construct(
            $user,
            $settings,
            $content,
            $path,
            $mailTemplate,
            $mailSubject,
            $notiType,
            $langKey,
            $notiParams
        );

        $this->courseDetail = $courseDetail;
        $this->bonusDetail = $bonusDetail;
        $this->mailSubjectParams = $mailSubjectParams;
    }

    public function via($notifiable)
    {
        return array_merge(['mail'], parent::via($notifiable));
    }

    public function toMail($notifiable)
    {
        return new BaseMailable($this->mailTemplate, [
            BaseMailable::EMAIL_FROM => _k('cmd_email'),
            BaseMailable::EMAIL_FROM_NAME =>  _k('cmd_name'),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->shownName,
            BaseMailable::EMAIL_SUBJECT => trans($this->mailSubject, $this->mailSubjectParams),
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => _k('cmd_name'),
            'courseDetail' => $this->courseDetail,
            'bonusDetail' => $this->bonusDetail,
            'url' => baseUrl($this->path, [], $this->settings->getBaseUrl()),
            'course_policy_url' => _k('course_policy_learner_url'),
            'course_guide_url' => _k('course_guide_url'),
            'reset_password_url' => _k('forgot_password_url'),
        ], currentLocaleCode());
    }
}
