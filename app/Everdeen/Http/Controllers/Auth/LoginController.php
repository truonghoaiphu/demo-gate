<?php

namespace Katniss\Everdeen\Http\Controllers\Auth;

use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Katniss\Everdeen\Http\Controllers\ViewController;
use Katniss\Everdeen\Http\Request;
use Katniss\Everdeen\Models\User;
use Katniss\Everdeen\Utils\CryptoJs\AES;
use Katniss\Everdeen\Utils\DateTimeHelper;
use Katniss\Everdeen\Utils\Settings;
use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;

class LoginController extends ViewController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $loginPath;
    protected $socialRegisterPath;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->viewPath = 'auth';
        $this->redirectTo = homePath('auth/inactive');
        $this->loginPath = homePath('auth/login');
        $this->socialRegisterPath = homePath('auth/register/social');

        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'account';
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        $this->_title(trans('pages.account_login_title'));
        $this->_description(trans('pages.account_login_desc'));

        return $this->_any('login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (!$this->validateLogin($request)) {
            return redirect($this->loginPath)
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors($this->getValidationErrors());
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);

        // try email
        $try_credentials = [
            'email' => $credentials[$this->username()],
            'password' => $credentials['password'],
        ];
        if ($this->guard()->attempt($try_credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }
        // try user name
        $try_credentials = [
            'name' => $credentials[$this->username()],
            'password' => $credentials['password'],
        ];
        if ($this->guard()->attempt($try_credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    /**
     * @param Request $request
     * @param User $user
     * @param Response|RedirectResponse $response
     * @return Response|RedirectResponse
     */
    protected function issuePassport(Request $request, User $user, $response)
    {
        $client = new Client();
        $passportResponse = $client->post(config('services.gate.url') . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => config('services.gate.pw_client_id'),
                'client_secret' => config('services.gate.pw_client_secret'),
                'username' => $request->input($this->username()),
                'password' => $request->input('password'),
                'scope' => '*',
            ]
        ]);
        $result = json_decode((string)$passportResponse->getBody());
        if ($result !== false && isset($result->access_token) && isset($result->token_type) && isset($result->refresh_token)) {
            $settings = new Settings();
            $settings->fromUser($user);
            $tokenLifeTime = (new DateTimeHelper($settings))->getObject()->getTimestamp() * 1000 + (int)_k('home_cookie_lifetime') * 60 * 1000;
            $storedToken = [
                'access_token' => $result->access_token,
                'token_type' => $result->token_type,
                'refresh_token' => $result->refresh_token,
                'token_end_time' => $tokenLifeTime,
                'user' => $user->id,
            ];
            $cookieValue = AES::encrypt(json_encode($storedToken), _k('home_encrypt_secret'));
            $response->headers->setCookie(
                new SymfonyCookie(
                    _k('home_cookie_name'), $cookieValue, $tokenLifeTime,
                    '/', _k('home_cookie_domain'), false, false, false, null
                )
            );
        }

        return $response;
    }

    /**
     * Validate the user login request.
     *
     * @param  \Katniss\Everdeen\Http\Request $request
     * @return boolean
     */
    protected function validateLogin(Request $request)
    {
        return $this->customValidate($request, [
            $this->username() => 'required', 'password' => 'required',
        ]);
    }

    protected function authenticated(Request $request, User $user)
    {
        return $this->issuePassport($request, $user, redirect(homeUrl('auth/inactive', [], $user->settings->locale)));
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $homeCookieDomain = _k('home_cookie_domain');
        Cookie::queue(Cookie::make(_k('home_cookie_name'), '', -1, '/', $homeCookieDomain));
        Cookie::queue(Cookie::make(_k('home_cookie_original_name'), '', -1, '/', $homeCookieDomain));
        foreach (explode(',', _k('extra_removing_cookies')) as $cookieName) {
            Cookie::queue(Cookie::make($cookieName, '', -1, '/', $homeCookieDomain));
        }

        return redirect('/');
    }
}
