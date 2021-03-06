<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2017-05-17
 * Time: 08:48
 */

namespace Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Katniss\Everdeen\Mail\BaseMailable;
use Katniss\Everdeen\Models\User;

class ResetPassword extends ResetPasswordNotification
{
    protected $user;
    protected $route;

    public function __construct($token, User $user)
    {
        parent::__construct($token);

        $request = request();
        $this->user = $user;
        $this->route = $request->has('route') ?
            $request->input('route') . '/{email}' : 'auth/reset-password/{token}/{email}';
    }

    public function toMail($notifiable)
    {
        $settings = settings();
        return new BaseMailable('forgot_password', [
            BaseMailable::EMAIL_FROM => $settings->getBaseEmail(),
            BaseMailable::EMAIL_FROM_NAME => $settings->getBaseName(),
            BaseMailable::EMAIL_TO => $this->user->email,
            BaseMailable::EMAIL_TO_NAME => $this->user->shown_name,
            BaseMailable::EMAIL_SUBJECT => '[' . $settings->getBaseName() . '] ' . trans('label.reset_password'),
            'base_url' => $settings->getBaseUrl(),
            'base_name' => $settings->getBaseName(),
            'shown_name' => $this->user->shown_name,
            'reset_url' => baseUrl($this->route, ['token' => $this->token, 'email' => $this->user->email]),
        ], currentLocaleCode());
    }
}