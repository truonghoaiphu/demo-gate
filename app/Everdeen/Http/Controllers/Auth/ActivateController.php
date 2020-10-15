<?php

namespace Katniss\Everdeen\Http\Controllers\Auth;

use Katniss\Everdeen\Http\Controllers\ViewController;
use Katniss\Everdeen\Http\Request;
use Katniss\Everdeen\Mail\BaseMailable;
use Katniss\Everdeen\Repositories\UserRepository;
use Katniss\Everdeen\Utils\MailHelper;

class ActivateController extends ViewController
{
    public function __construct()
    {
        parent::__construct();

        $this->viewPath = 'auth';

        $this->middleware('guest');
    }

    public function getInactive(Request $request)
    {
        if ($request->authUser()->email_verified) {
            return redirect(redirectUrlAfterLogin($request->authUser()));
        }

        $this->_title(trans('pages.account_inactive_title'));
        $this->_description(trans('pages.account_inactive_desc'));

        return $this->_any('inactive', ['resend' => false]);
    }

    public function postInactive(Request $request)
    {
        $authUser = $request->authUser();
        MailHelper::sendTemplate('welcome', array_merge([
            BaseMailable::EMAIL_SUBJECT => trans('label.welcome_to_') . appName(),
            BaseMailable::EMAIL_TO => $authUser->email,
            BaseMailable::EMAIL_TO_NAME => $authUser->display_name,

            'id' => $authUser->id,
            'display_name' => $authUser->display_name,
            'name' => $authUser->name,
            'email' => $authUser->email,
            'password' => '******',
            'verification_code' => $authUser->verification_code,
            'url_activate' => homeUrl(
                'auth/verify-email/{id}/{verification_code}',
                [
                    'id' => $authUser->id,
                    'verification_code' => $authUser->verification_code
                ]
            ),
        ], $this->_params()));

        $this->_title(trans('pages.account_inactive_title'));
        $this->_description(trans('pages.account_inactive_title'));

        return $this->_any('inactive', ['resend' => true]);
    }

    public function getActivation(Request $request, $id, $verificationCode)
    {
        // if user has logged in but has the id not equals $id, the activation will not process
        // due to the middleware 'guest' applied to this controller in the constructor

        $userRepository = new UserRepository($id);
        $user = $userRepository->model();
        $active = $user->verification_code == $verificationCode;
        if ($active) {
            $user->email_verified = true;
            $user->save();
        }

        $this->_title(trans('pages.account_activate_title'));
        $this->_description(trans('pages.account_activate_title'));

        return $this->_any('activate', [
            'active' => $active,
            'url' => $request->isAuth() ? redirectUrlAfterLogin($request->authUser()) : homeUrl('auth/login'),
        ]);
    }
}
