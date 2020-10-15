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
use Katniss\Everdeen\Models\User;
use Katniss\Everdeen\Utils\Settings;
use Katniss\Everdeen\Models\SysToken;
use Illuminate\Notifications\Messages\BroadcastMessage;

class LearnerPaymentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $settings;
    protected $paymentInfo;
    protected $learnerInfo;

    public function __construct(User $user, $paymentInfo, $learnerInfo, Settings $settings)
    {
        $this->user = $user;
        $this->paymentInfo = $paymentInfo;
        $this->settings = $settings;
        $this->learnerInfo = $learnerInfo;
    }

    public function via($notifiable)
    {
        return ['mail', 'broadcast', 'database'];
    }

    public function toArray()
    {
        return [
            'type' => Channel::TYPE_NOTIFICATION,
            'content' => 'Learner\'s name: ' . $this->learnerInfo['display_name'] . '\n' .
                         'Learner\'s email: ' . $this->learnerInfo['email'] . '\n' . 
                         'Amount: ' . $this->paymentInfo['email'] . ' ' . $this->paymentInfo['currency'],
            'path' => baseUrl('confirm-learner-payment/{payment_id}/{token}', [
                'payment_id' => $this->paymentInfo['payment_id'],
                'token' => $token->token,
            ], $this->settings->getBaseUrl()),
        ];
    }

    public function toMail($notifiable)
    {
        $key = str_random(128);
        $token = SysToken::create([
            'token' => $key,
            'type' => SysToken::TYPE_LOGIN,
        ]);
        return new BaseMailable('learner_payment_confirm', [
            BaseMailable::EMAIL_FROM => $this->settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $this->settings->getBaseName(),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->display_name,
            BaseMailable::EMAIL_SUBJECT => '[' . $this->settings->getBaseName() . '] ' . trans('label.email_learner_payment_confirm'),
            'base_url' => $this->settings->getBaseUrl(),
            'base_name' => $this->settings->getBaseName(),
            'email' => $this->user->email,
            'shown_name' => $this->user->shown_name,
            'learner_info'  =>  $this->learnerInfo,
            'payment_info'  =>  $this->paymentInfo,
            'url_confirm' => baseUrl('confirm-learner-payment/{payment_id}/{token}', [
                'payment_id' => $this->paymentInfo['payment_id'],
                'token' => $token->token,
            ], $this->settings->getBaseUrl()),
        ], currentLocaleCode());
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
}