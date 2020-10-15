<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2017-12-27
 * Time: 09:58
 */

namespace Katniss\Everdeen\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Katniss\Everdeen\Http\Request;
use Katniss\Everdeen\Utils\CryptoJs\AES;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Guards\TokenGuard;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\ResourceServer;

class HomeCookieMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $homeCookieName = _k('home_cookie_name');
        if (!auth()->check() && $request->hasCookie($homeCookieName)) {
            $token = json_decode(AES::decrypt($request->cookie($homeCookieName), _k('home_encrypt_secret')));
            if ($token !== false && isset($token->access_token) && isset($token->token_type) && isset($token->refresh_token) && isset($token->token_end_time)) {
                $request->headers->set(
                    'Authorization',
                    $token->token_type . ' ' . $token->access_token
                );

                $app = app();
                $user = (new TokenGuard(
                    $app->make(ResourceServer::class),
                    Auth::createUserProvider('users'),
                    new TokenRepository(),
                    $app->make(ClientRepository::class),
                    $app->make('encrypter')
                ))->user($request);

                if (!empty($user)) {
                    auth()->login($user);
                }
            }
        }

        return $next($request);
    }
}