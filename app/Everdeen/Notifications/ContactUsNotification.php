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
use Katniss\Everdeen\Models\ContactUs;

class ContactUsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $contact;
    protected $settings;

    public function __construct(ContactUs $contact, Settings $settings)
    {
        $this->contact = $contact;
        $this->settings = $settings;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return new BaseMailable('contact_us', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => env('APP_EMAIL'),
            BaseMailable::EMAIL_TO_NAME => env('APP_AUTHOR'),
            BaseMailable::EMAIL_SUBJECT => '[Antoree] Contact Us',
            'contact' => $this->contact,
        ], currentLocaleCode());
    }
}