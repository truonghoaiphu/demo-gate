<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-12-07
 * Time: 05:02
 */

namespace Katniss\Everdeen\Http\Middleware;

use Closure;
use Katniss\Everdeen\Http\Request;
use Katniss\Everdeen\Utils\SettingsFacade;

class ApiMiddleware
{
    protected function checkSettings(Request $request)
    {
        if (!SettingsFacade::fromApi($request)) {
            SettingsFacade::fromUser();
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Katniss\Everdeen\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->checkSettings($request);

        setCurrentLocale(SettingsFacade::getLocale());

        return $next($request);
    }
}