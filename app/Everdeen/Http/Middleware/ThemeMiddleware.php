<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2016-12-26
 * Time: 13:58
 */

namespace Katniss\Everdeen\Http\Middleware;

use Closure;
use Katniss\Everdeen\Http\Request;
use Katniss\Everdeen\Themes\Extensions;
use Katniss\Everdeen\Themes\Theme;
use Katniss\Everdeen\Utils\AppConfig;
use Katniss\Everdeen\Utils\Storage\StoreFile;

class ThemeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $this->initTheme($request);

        return $next($request);
    }

    public function initTheme(Request $request)
    {
        $theme = $this->checkForceTheme($request);
        if ($theme === false) {
            $theme = $this->getDefaultTheme($request);
            if ($theme === false) {
                abort(404);
            }
        }

        $request->setTheme($theme);
        $this->bootingTheme($request);
        $this->prepareTheme($request);
    }

    /**
     * @param Request $request
     * @return bool|Theme
     */
    protected function checkForceTheme(Request $request)
    {
        if ($request->has(AppConfig::KEY_FORCE_THEME)) {
            $themeDefines = $request->getUrlPathInfo()->admin ? _k('admin_themes') : _k('home_themes');
            $forceThemeName = $request->input(AppConfig::KEY_FORCE_THEME);
            if (array_key_exists($forceThemeName, $themeDefines)) {
                $themeClass = $themeDefines[$forceThemeName];
                return new $themeClass();
            }
        }

        return false;
    }

    /**
     * @param Request $request
     * @return bool|Theme
     */
    protected function getDefaultTheme(Request $request)
    {
        $themeFromDb = _k('theme_from_db');
        if ($request->getUrlPathInfo()->admin) {
            $themeDefines = _k('admin_themes');
            $themeName = $themeFromDb ?
                getOption('admin_theme', _k('admin_theme')) : _k('admin_theme');
        } else {
            $themeDefines = _k('home_themes');
            $themeName = $themeFromDb ?
                getOption('home_theme', _k('home_theme')) : _k('home_theme');
        }
        if (array_key_exists($themeName, $themeDefines)) {
            $themeClass = $themeDefines[$themeName];
            return new $themeClass();
        }

        return false;
    }

    protected function bootingTheme(Request $request)
    {
        $app = app();

        $app->singleton('katniss_theme', function () use ($request) {
            return $request->getTheme();
        });

        $app->singleton('katniss_extensions', function () {
            return new Extensions();
        });
    }

    protected function prepareTheme(Request $request)
    {
        $theme = $request->getTheme();
        $theme->register($request->isAuth());

        $viewParams = [
            'site_locale' => currentLocaleCode(),
            'site_version' => appVersion(),
            'site_name' => appName(),
            'site_logo' => appLogo(),
            'site_keywords' => appKeywords(),
            'site_short_name' => appShortName(),
            'site_description' => appDescription(),
            'site_author' => appAuthor(),
            'site_email' => appEmail(),
            'site_domain' => appDomain(),
            'site_home_url' => homeUrl(),
            'is_auth' => $request->isAuth(),
            'auth_user' => $request->authUser(),
            'max_upload_file_size_in_kb' => StoreFile::asKb(StoreFile::maxUploadFileSize()),
        ];
        if ($request->hasSession()) {
            $session = $request->session();
            $viewParams['session_id'] = $session->getId();
            $viewParams['successes'] = $session->has('successes') ?
                collect((array)$session->get('successes')) : collect([]);
            $viewParams['info'] = $session->has('info') ?
                collect((array)$session->get('info')) : collect([]);
        }
        $viewParams = $theme->viewParams($viewParams);
        foreach ($viewParams as $key => $value) {
            view()->share($key, $value);
        }

        $request->setTheme($theme);
    }
}