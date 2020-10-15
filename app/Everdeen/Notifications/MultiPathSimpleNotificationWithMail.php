<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2017-05-30
 * Time: 16:43
 */

namespace Katniss\Everdeen\Notifications;


use Katniss\Everdeen\Mail\BaseMailable;
use Katniss\Everdeen\Models\User;
use Katniss\Everdeen\Utils\Settings;

class MultiPathSimpleNotificationWithMail extends MultiPathSimpleNotification
{
    protected $user;
    protected $settings;
    protected $mailTemplate;
    protected $mailSubject;

    /**
     * MultiPathSimpleNotificationWithMail constructor.
     * @param User $user
     * @param Settings $settings
     * @param string $content
     * @param array $paths
     * @param string $mailTemplate
     * @param string $mailSubject
     */
    public function __construct(
        $user,
        $settings,
        $content,
        $paths = [],
        $mailTemplate = 'multi_path_simple_notification',
        $mailSubject = 'label.notification'
    )
    {
        parent::__construct($content, $paths);

        $this->user = $user;
        $this->settings = $settings;
        $this->mailTemplate = $mailTemplate;
        $this->mailSubject = $mailSubject;
    }

    public function via($notifiable)
    {
        return array_merge(['mail'], parent::via($notifiable));
    }

    public function toMail($notifiable)
    {
        $urls = [];
        foreach ($this->paths as $key => $path) {
            $urls[_k('base_urls.' . $key . '.title')] = baseUrl($path, [], _k('base_urls.' . $key . '.url'));
        }
        return new BaseMailable($this->mailTemplate, [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->showName,
            BaseMailable::EMAIL_SUBJECT => '[' . $this->settings->getBaseName() . '] ' . trans($this->mailSubject),
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'content' => $this->content,
            'urls' => $urls,
        ], currentLocaleCode());
    }
}