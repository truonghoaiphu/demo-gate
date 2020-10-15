<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-12-06
 * Time: 17:24
 */

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;
use Jenssegers\Agent\Agent as AgentInstance;
use Jenssegers\Agent\Facades\Agent;
use Katniss\Everdeen\Exceptions\KatnissException;
use Katniss\Everdeen\Http\Request;
use Katniss\Everdeen\Models\User;
use Katniss\Everdeen\Themes\ExtensionsFacade;
use Katniss\Everdeen\Themes\Theme;
use Katniss\Everdeen\Themes\ThemeFacade;
use Katniss\Everdeen\Utils\AppConfig;
use Katniss\Everdeen\Utils\AppOptionHelper;
use Katniss\Everdeen\Utils\CurrentDevice;
use Katniss\Everdeen\Utils\DateTimeHelper;
use Katniss\Everdeen\Utils\ExtraActions\ActionHook;
use Katniss\Everdeen\Utils\ExtraActions\ActionContentFilter;
use Katniss\Everdeen\Utils\ExtraActions\ActionContentPlace;
use Katniss\Everdeen\Utils\ExtraActions\ActionTrigger;
use Katniss\Everdeen\Utils\ExtraActions\CallableObject;
use Katniss\Everdeen\Utils\HtmlTag\Html5;
use Katniss\Everdeen\Utils\NumberFormatHelper;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Ramsey\Uuid\Uuid;

#region Katniss Configuration
/**
 * Get katniss configuration
 *
 * @param string|null $key
 * @param mixed $default
 * @return string|mixed
 */
function _k($key = null, $default = null)
{
    if (is_null($key)) {
        return config('katniss');
    }

    if (is_array($key)) {
        $keyTemp = [];
        foreach ($key as $k => $v) {
            $keyTemp['katniss.' . $k] = $v;
        }
        return config($keyTemp);
    }

    return config('katniss.' . $key, $default);
}

function _kExternalLink($key = null, $default = null)
{
    if (is_null($key)) {
        return config('katniss.external_links');
    }

    if (is_array($key)) {
        $keyTemp = [];
        foreach ($key as $k => $v) {
            $keyTemp['katniss.external_links.' . $k] = $v;
        }
        return config($keyTemp);
    }

    return config('katniss.external_links.' . $key, $default);
}

function _kWidgets($key = null, $default = null)
{
    if (is_null($key)) {
        return config('katniss.widgets');
    }

    if (is_array($key)) {
        $keyTemp = [];
        foreach ($key as $k => $v) {
            $keyTemp['katniss.widgets.' . $k] = $v;
        }
        return config($keyTemp);
    }

    return config('katniss.widgets.' . $key, $default);
}

#endregion

#region Runtime
/**
 * @return int Session timeout in milliseconds
 */
function sessionLifetime()
{
    return intval(config('session.lifetime')) * 60 * 1000;
}

function appKey()
{
    return config('app.key');
}

function appName()
{
    return config('app.name');
}

function appDescription()
{
    return _k('app.description');
}

function appKeywords()
{
    return _k('app.keywords');
}

function appShortName()
{
    return _k('app.short_name');
}

function appVersion()
{
    return _k('app.version');
}

function frameworkVersion()
{
    return 'Laravel v' . \Illuminate\Foundation\Application::VERSION;
}

function appAuthor()
{
    return _k('app.author');
}

function appEmail()
{
    return _k('app.email');
}

function appLogo()
{
    return _k('app.logo');
}

function appDomain()
{
    $parsedUrl = parse_url(config('app.url'));
    return $parsedUrl['host'];
}

function appDefaultUserProfilePicture()
{
    return _k('app.default_user_picture');
}
#endregion

#region Logging
function logInfo(\Exception $exception, $group = 0)
{
    $id = Uuid::uuid1();
    $ip = request()->ip();
    $device = stringifyClientInfo();
    $user = authUser();

    $message = $exception instanceof KatnissException ?
        $exception->getMessage() . ' (Data: ' . json_encode($exception->getAttachedData()) . ')' : $exception->getMessage();
    Log::info(implode(' ', [
        $id,
        $group,
        empty($user) ? 0 : $user->id,
        $ip . '[' . $device . ']',
        $exception->getFile(),
        $exception->getLine(),
        $message
    ]));
}

function logError(\Exception $exception, $group = 0)
{
    $id = Uuid::uuid1();
    $ip = request()->ip();
    $device = stringifyClientInfo();
    $user = authUser();

    $message = $exception instanceof KatnissException ?
        $exception->getMessage() . ' (Data: ' . json_encode($exception->getAttachedData()) . ')' : $exception->getMessage();
    Log::error(implode(' ', [
        $id,
        $group,
        empty($user) ? 0 : $user->id,
        $ip . '[' . $device . ']',
        $exception->getFile(),
        $exception->getLine(),
        $message
    ]));
}

#endregion

#region Current User / Device / Client
function isPhoneClient()
{
    return Agent::isPhone();
}

function isDesktopClient()
{
    return Agent::isDesktop();
}

function isMobileClient()
{
    return Agent::isMobile();
}

function isTabletClient()
{
    return Agent::isTablet();
}

function clientIp()
{
    return request()->ip();
}

function stringifyClientInfo()
{
    $agent = new AgentInstance();
    $device = [];
    if ($agent->isMobile() || $agent->isTablet()) {
        $device[] = $agent->device();
    }
    $device[] = $agent->platform() . ' (' . $agent->version($agent->platform()) . ')';
    $device[] = $agent->browser() . ' (' . $agent->version($agent->browser()) . ')';
    $device[] = request()->header('User-Agent');
    return implode(', ', $device);
}

function isAuth()
{
    return auth()->check();
}

function authUser()
{
    return isAuth() ? auth()->user() : null;
}

function device()
{
    return CurrentDevice::getDevice();
}

function hasDevice()
{
    return !empty(CurrentDevice::getDevice());
}

function deviceId()
{
    return CurrentDevice::getDeviceId();
}

function deviceSecret()
{
    return CurrentDevice::getDeviceSecret();
}

function deviceRealId()
{
    return CurrentDevice::getDeviceRealId();
}

/**
 * @return Katniss\Everdeen\Utils\Settings
 */
function settings()
{
    return app('settings');
}

#endregion

#region Locale
function setCurrentLocale($localeCode)
{
    LaravelLocalization::setLocale($localeCode);
}

function fullLocaleCode($localeCode, $separator = '_')
{
    return $localeCode . $separator . allLocale($localeCode, 'country_code');
}

/**
 * @return array
 */
function allLocales()
{
    return config('katniss.locales');
}

/**
 * @return array
 */
function allLocaleCodes()
{
    return array_keys(allLocales());
}

/**
 * @param string $localeCode
 * @param string $property
 * @return array|string|null
 */
function allLocale($localeCode, $property = '')
{
    $locales = allLocales();
    if (empty($locales[$localeCode])) return null;
    return empty($property) || $property == 'all' ? $locales[$localeCode] : $locales[$localeCode][$property];
}

/**
 * @return array
 */
function allSupportedLocales()
{
    return config('laravellocalization.supportedLocales');
}

/**
 * @return array
 */
function allSupportedLocaleCodes()
{
    static $supportedLocaleCodes;
    if (!isset($supportedLocaleCodes)) {
        $supportedLocaleCodes = array_keys(allSupportedLocales());
    }
    return $supportedLocaleCodes;
}

/**
 * @return array
 */
function allSupportedFullLocaleCodes()
{
    $localeCodes = allSupportedLocaleCodes();
    $fullLocaleCodes = [];
    foreach ($localeCodes as $localeCode) {
        $fullLocaleCodes[] = fullLocaleCode($localeCode);
    }
    return $fullLocaleCodes;
}

/**
 * @param string $localeCode
 * @param string $property
 * @return array|string|null
 */
function allSupportedLocale($localeCode, $property = '')
{
    $locales = allSupportedLocales();
    if (empty($locales[$localeCode])) return null;
    return empty($property) || $property == 'all' ? $locales[$localeCode] : $locales[$localeCode][$property];
}

function supportedLocalesAsOptions()
{
    $selected_locale = currentLocaleCode();
    $options = '';
    foreach (allSupportedLocales() as $localeCode => $properties) {
        $options .= '<option value="' . $localeCode . '"' . ($localeCode == $selected_locale ? ' selected' : '') . '>' . $properties['native'] . '</option>';
    }
    return $options;
}

function supportedLocalesAsInputTabs()
{
    return array_merge([
        AppConfig::INTERNATIONAL_LOCALE_CODE => [
            'native' => trans('label.default'),
        ]
    ], allSupportedLocales());
}

function supportedLocaleCodesOfInputTabs()
{
    $locales = allSupportedLocaleCodes();
    array_unshift($locales, AppConfig::INTERNATIONAL_LOCALE_CODE);
    return $locales;
}

function currentLocaleCode($property = '')
{
    if (empty($property)) {
        return app()->getLocale();
    };
    return allSupportedLocale(app()->getLocale(), $property);
}

function currentFullLocaleCode($separator = '_')
{
    return fullLocaleCode(currentLocaleCode(), $separator);
}

#endregion

#region Route / Path / URL
function transRoute($route)
{
    return LaravelLocalization::transRoute('routes.' . $route);
}

function homeRoute($route)
{
    return transRoute($route);
}

function adminRoute($route)
{
    return transRoute('admin/' . $route);
}

function oauthRoute($route)
{
    return transRoute('oauth/' . $route);
}

function embedParamsInRoute($route, array $params = [])
{
    if (empty($params)) return $route;
    foreach ($params as $key => $value) {
        $route = str_replace(['{' . $key . '}', '{' . $key . '?}'], $value, $route);
    }
    return $route;
}

function currentPath()
{
    $path = parse_url(currentUrl())['path'];
    return empty($path) ? '/' : $path;
}

function transPath($route = '', array $params = [], $localeCode = null)
{
    if (empty($localeCode)) {
        $localeCode = currentLocaleCode();
    }
    if (empty($route)) {
        return $localeCode;
    }
    $route = trans('routes.' . $route, [], $localeCode);
    return $localeCode . '/' . embedParamsInRoute($route, $params);
}

function homePath($route = '', array $params = [], $localeCode = null)
{
    return transPath($route, $params, $localeCode);
}

function adminPath($route = '', array $params = [], $localeCode = null)
{
    return empty($route) ? homePath('admin', $params, $localeCode) : homePath('admin/' . $route, $params, $localeCode);
}

function currentUrl($localeCode = null)
{
    if (empty($localeCode)) {
        return request()->url();
    }

    return LaravelLocalization::getLocalizedUrl($localeCode, null);
}

function currentFullUrl($localeCode = null)
{
    if (empty($localeCode)) {
        return request()->fullUrl();
    }
    $url_parts = parse_url(request()->fullUrl());
    $localizedUrl = LaravelLocalization::getLocalizedUrl($localeCode, request()->url());
    $query = empty($url_parts['query']) ? '' : '?' . $url_parts['query'];
    $hash = empty($url_parts['hash']) ? '' : '#' . $url_parts['hash'];
    return $localizedUrl . $query . $hash;
}

function transUrl($route = '', array $params = [], $localeCode = null)
{
    $path = transPath($route, $params, $localeCode);
    return url($path);
}

function homeUrl($route = '', array $params = [], $localeCode = null)
{
    return transUrl($route, $params, $localeCode);
}

function adminUrl($route = '', array $params = [], $localeCode = null)
{
    return empty($route) ? homeUrl('admin', $params, $localeCode) : homeUrl('admin/' . $route, $params, $localeCode);
}

function meUrl($route = '', array $params = [], $localeCode = null)
{
    return empty($route) ? homeUrl('me', $params, $localeCode) : homeUrl('me/' . $route, $params, $localeCode);
}

function notRootUrl($url)
{
    return $url != homeUrl() && $url != adminUrl();
}

function rootUrl()
{
    return url('');
}

function apiUrl($route = '', array $params = [], $version = 'v1')
{
    return url('api/' . $version . '/' . embedParamsInRoute($route, $params));
}

function webApiUrl($route = '', array $params = [])
{
    return url('web-api/' . embedParamsInRoute($route, $params));
}

function baseUrl($route, array $params = [], $baseUrl = null)
{
    if (empty($baseUrl)) {
        $baseUrl = settings()->getBaseUrl();
    }
    return $baseUrl . '/' . embedParamsInRoute($route, $params);
}

function addExtraUrl($path, $mainUrl = null, $separatedChar = '')
{
    if (empty($mainUrl)) {
        $mainUrl = request()->fullUrl();
    }
    $pathParam = AppConfig::KEY_EXTRA_ROUTE . '=' . urlencode($path);
    if (!empty($separatedChar)) return $mainUrl . $separatedChar . $pathParam;
    $parsed = parse_url($mainUrl);
    return empty($parsed['query']) ? $mainUrl . '?' . $pathParam : $mainUrl . '&' . $pathParam;
}

function addRdrUrl($mainUrl, $rdrUrl = null, $separatedChar = '')
{
    if (empty($rdrUrl)) {
        $rdrUrl = request()->fullUrl();
    }
    $rdrParam = AppConfig::KEY_REDIRECT_URL . '=' . urlencode($rdrUrl);
    if (!empty($separatedChar)) return $mainUrl . $separatedChar . $rdrParam;
    $parsed = parse_url($mainUrl);
    return empty($parsed['query']) ? $mainUrl . '?' . $rdrParam : $mainUrl . '&' . $rdrParam;
}

function addWizardUrl($mainUrl, $name, $key, $separatedChar = '')
{
    if (empty($mainUrl)) {
        $mainUrl = request()->fullUrl();
    }
    $wizardParams = AppConfig::KEY_WIZARD_NAME . '=' . $name . '&' . AppConfig::KEY_WIZARD_KEY . '=' . $key;
    if (!empty($separatedChar)) return $mainUrl . $separatedChar . $wizardParams;
    $parsed = parse_url($mainUrl);
    return empty($parsed['query']) ? $mainUrl . '?' . $wizardParams : $mainUrl . '&' . $wizardParams;
}

function addErrorUrl($mainUrl, $rdrUrl = null, $separatedChar = '')
{
    if (empty($rdrUrl)) {
        $rdrUrl = request()->fullUrl();
    }
    $rdrParam = AppConfig::KEY_REDIRECT_ON_ERROR_URL . '=' . urlencode($rdrUrl);
    if (!empty($separatedChar)) return $mainUrl . $separatedChar . $rdrParam;
    $parsed = parse_url($mainUrl);
    return empty($parsed['query']) ? $mainUrl . '?' . $rdrParam : $mainUrl . '&' . $rdrParam;
}

function addThemeUrl($mainUrl, $theme, $separatedChar = '')
{
    $themeParam = AppConfig::KEY_FORCE_THEME . '=' . $theme;
    if (!empty($separatedChar)) return $mainUrl . $separatedChar . $themeParam;
    $parsed = parse_url($mainUrl);
    return empty($parsed['query']) ? $mainUrl . '?' . $themeParam : $mainUrl . '&' . $themeParam;
}

function redirectUrlAfterLogin(User $user)
{
    $localeCode = $user->settings->locale;
    $redirect_url = homeUrl();
    $overwrite_url = session()->pull(AppConfig::KEY_REDIRECT_URL);
    if (!empty($overwrite_url)) {
        $redirect_url = $overwrite_url;
    } elseif ($user->can('access-admin')) {
        $redirect_url = adminUrl(null, [], $localeCode);
    }
    return $redirect_url;
}

#endregion

#region App Options
function loadOptions()
{
    return AppOptionHelper::load();
}

function setOption($key, $value, $registeredBy = null)
{
    return AppOptionHelper::set($key, $value, $registeredBy);
}

function getOption($key, $default = '')
{
    return AppOptionHelper::get($key, $default);
}

#endregion

#region Extensible
/**
 * @param string $id
 * @param CallableObject $callableObject
 * @param string $name
 * @param bool $strict
 */
function addAction($id, CallableObject $callableObject, $name, $strict = true)
{
    ActionHook::add($id, $callableObject, $name, $strict);
}

function hasAction($id, $name)
{
    return ActionHook::has($id, $name);
}


function removeAction($id, $name)
{
    return ActionHook::remove($id, $name);
}

function doAction($id, array $params = [])
{
    return ActionHook::activate($id, $params);
}

/**
 * @param string $id
 * @param CallableObject $callableObject
 * @param string $name
 * @param bool $strict
 */
function addTrigger($id, CallableObject $callableObject, $name, $strict = true)
{
    ActionTrigger::add($id, $callableObject, $name, $strict);
}

function addExtraRouteResourceTriggers($resourceRoute, $controllerClass)
{
    addTrigger('extra_route', new CallableObject(function (Request $request) use ($controllerClass) {
        $controller = new $controllerClass;
        switch (strtolower($request->method())) {
            case 'get':
                return $controller->index($request);
                break;
            case 'post':
                return $controller->store($request);
                break;
            default:
                return '';
        }
    }), $resourceRoute);

    addTrigger('extra_route', new CallableObject(function (Request $request) use ($controllerClass) {
        $controller = new $controllerClass;
        switch (strtolower($request->method())) {
            case 'get':
                return $controller->create($request);
                break;
            default:
                return '';
        }
    }), $resourceRoute . '/create');

    addTrigger('extra_route', new CallableObject(function (Request $request) use ($controllerClass) {
        $controller = new $controllerClass;
        switch (strtolower($request->method())) {
            case 'get':
                return $controller->show($request, $request->input('id'));
                break;
            case 'put':
                return $controller->update($request, $request->input('id'));
                break;
            case 'delete':
                return $controller->destroy($request, $request->input('id'));
                break;
            default:
                return '';
        }
    }), $resourceRoute . '/id');

    addTrigger('extra_route', new CallableObject(function (Request $request) use ($controllerClass) {
        $controller = new $controllerClass;
        switch (strtolower($request->method())) {
            case 'get':
                return $controller->edit($request, $request->input('id'));
                break;
            default:
                return '';
        }
    }), $resourceRoute . '/id/edit');
}

function hasTrigger($id, $name)
{
    return ActionTrigger::has($id, $name);
}

function removeTrigger($id, $name)
{
    return ActionTrigger::remove($id, $name);
}

function doTrigger($id, $name, array $params = [])
{
    return ActionTrigger::activate($id, $name, $params);
}

/**
 * @param string $id
 * @param CallableObject $callableObject
 * @param string $name
 * @param bool $strict
 */
function addFilter($id, CallableObject $callableObject, $name, $strict = true)
{
    ActionContentFilter::add($id, $callableObject, $name, $strict);
}

function hasFilter($id, $name)
{
    return ActionContentFilter::has($id, $name);
}

function removeFilter($id, $name)
{
    return ActionContentFilter::remove($id, $name);
}

/**
 * @param string $id
 * @param string|mixed $content
 * @return mixed
 */
function contentFilter($id, $content, array $params = [])
{
    return ActionContentFilter::flush($id, $content, $params);
}

/**
 * @param string $id
 * @param CallableObject $callableObject
 * @param string $name
 * @param bool $strict
 */
function addPlace($id, CallableObject $callableObject, $name, $strict = true)
{
    ActionContentPlace::add($id, $callableObject, $name, $strict);
}

function hasPlace($id, $name)
{
    return ActionContentPlace::has($id, $name);
}

function removePlace($id, $name)
{
    return ActionContentPlace::remove($id, $name);
}

/**
 * @param string $id
 * @return string
 */
function contentPlace($id, array $params = [], $before = '', $after = '')
{
    $content = ActionContentPlace::flush($id, $params);
    if (!empty($content)) {
        $content = $before . $content . $after;
    }
    return $content;
}

#endregion

#region Theme
function embedConversation($id)
{
    return new HtmlString(Html5::frame(addThemeUrl(webApiUrl('conversations/' . $id) . '?messages=1', 'conversation')));
}

/**
 * @param string $file_path
 * @return string
 */
function libraryAsset($file_path = '')
{
    return Theme::libraryAsset($file_path);
}

function themeImageAsset($file_path = '')
{
    return ThemeFacade::imageAsset($file_path);
}

function cdataOpen()
{
    return '//<![CDATA[';
}

function cdataClose()
{
    return '//]]>';
}

function placeholder($name, $before = '', $after = '', $default = '')
{
    return WidgetsFacade::display($name, $before, $after, $default);
}

function activatedExtensions()
{
    return ExtensionsFacade::activated();
}

function isActivatedExtension($extension)
{
    return ExtensionsFacade::isActivated($extension);
}

function isStaticExtension($extension)
{
    return ExtensionsFacade::isStatic($extension);
}

function themeTitle($titles = '', $use_root = true)
{
    return ThemeFacade::title($titles, $use_root);
}

function themeDescription($description = '')
{
    return ThemeFacade::description($description);
}

function themeAuthor($author = '')
{
    return ThemeFacade::author($author);
}

function themeApplicationName($applicationName = '')
{
    return ThemeFacade::applicationName($applicationName);
}

function themeGenerator($generator = '')
{
    return ThemeFacade::generator($generator);
}

function themeKeywords($keywords = '')
{
    return ThemeFacade::keywords($keywords);
}

function libStyles()
{
    return ThemeFacade::getLibCss();
}

function extStyles()
{
    return ThemeFacade::getExtCss();
}

function libScripts()
{
    return ThemeFacade::getLibJs();
}

function extScripts()
{
    return ThemeFacade::getExtJs();
}

/**
 * @param string|CallableObject $output
 * @param string|integer|null $key
 */
function enqueueThemeHeader($output, $key = null)
{
    return ThemeFacade::addHeader($output, $key);
}

function dequeueThemeHeader($key)
{
    return ThemeFacade::removeHeader($key);
}

function themeHeader()
{
    return ThemeFacade::getHeader();
}

/**
 * @param string|CallableObject $output
 * @param string|integer|null $key
 */
function enqueueThemeFooter($output, $key = null)
{
    return ThemeFacade::addFooter($output, $key);
}

function dequeueThemeFooter($key)
{
    return ThemeFacade::removeFooter($key);
}

function themeFooter()
{
    return ThemeFacade::getFooter();
}

/**
 * @return bool
 */
function inAdmin()
{
    return request()->getUrlPathInfo()->admin;
}

/**
 * @return bool|\Katniss\Everdeen\Themes\HomeThemes\HomeTheme
 */
function homeTheme()
{
    static $theme = null;

    if ($theme == null) {
        if (!inAdmin()) {
            $theme = request()->getTheme();
        } else {
            $themeDefines = _k('home_themes');
            $themeName = getOption('home_theme', _k('home_theme'));
            if (array_key_exists($themeName, $themeDefines)) {
                $themeClass = $themeDefines[$themeName];
                $theme = new $themeClass();
            } else {
                $theme = false;
            }
        }
    }
    return $theme;
}

function homeThemePlaceholders()
{
    $homeTheme = homeTheme();
    return $homeTheme !== false ? $homeTheme->placeholders() : [];
}

function homeThemeMockAdmin()
{
    $homeTheme = homeTheme();
    if ($homeTheme !== false) {
        $homeTheme->mockAdmin();
    }
}

function homeThemeExtensions()
{
    $homeTheme = homeTheme();
    return $homeTheme !== false ? $homeTheme->extensions() : [];
}

/**
 * @return bool|\Katniss\Everdeen\Themes\AdminThemes\AdminTheme
 */
function adminTheme()
{
    static $theme = null;

    if ($theme == null) {
        if (inAdmin()) {
            $theme = request()->getTheme();
        } else {
            $themeDefines = _k('admin_themes');
            $themeName = getOption('admin_theme', _k('admin_theme'));
            if (array_key_exists($themeName, $themeDefines)) {
                $themeClass = $themeDefines[$themeName];
                $theme = new $themeClass();
            } else {
                $theme = false;
            }
        }
    }
    return $theme;
}

#endregion

#region Utilities
function globalPage()
{
    $page = intval(request()->input('page'));
    return $page < 1 ? 1 : $page;
}

/**
 * @param mixed $input
 * @param string $type
 * @return string
 */
function escapeObject($input, &$type)
{
    $type = 'string';
    if (empty($input)) return '';

    if ($input instanceof Arrayable && !$input instanceof \JsonSerializable) {
        $input = $input->toArray();
    } elseif ($input instanceof Jsonable) {
        $type = 'array';
        $input = $input->toJson();
    }
    if (is_array($input)) {
        $type = 'array';
        return json_encode($input);
    } elseif (is_bool($input)) {
        $type = 'bool';
        $input = $input ? '1' : '0';
    } elseif (is_float($input)) {
        $type = 'float';
    } elseif (is_int($input)) {
        $type = 'int';
    }

    return !is_string($input) ? (string)$input : $input;
}

function fromEscapedObject($input, $type)
{
    switch ($type) {
        case 'array':
            return json_decode($input, true);
        case 'bool':
            return boolval($input);
        case 'int':
            return intval($input);
        case 'float':
            return floatval($input);
        default:
            return $input;
    }
}

function defPr($value, $default)
{
    return empty($value) ? $default : $value;
}

function defArrItem($arr, $index, $default)
{
    return isset($arr[$index]) ? $arr[$index] : $default;
}

function isEmptyString($input, $field = null)
{
    return is_null($field) ?
        !isset($input) || (is_string($input) && trim($input) == '')
        : !isset($input[$field]) || (is_string($input[$field]) && trim($input[$field]) == '');
}

function isEmptyArray($array)
{
    foreach ((array)$array as $item) {
        if (is_array($item)) {
            $empty = isEmptyArray($item);
        } else {
            $empty = empty($item);
        }
        if (!$empty) return false;
    }
    return true;
}

/**
 * @param string $name
 * @return string
 */
function wizardKey($name = '')
{
    return Hash::make($name . appKey());
}

/**
 * @param string $key
 * @param string $name
 * @return bool
 */
function isValidWizardKey($key, $name = '')
{
    return Hash::check($name . appKey(), $key);
}

/**
 * @param string $password
 * @param User $user
 * @return bool
 */
function isMatchedUserPassword($password, User $user = null)
{
    if (empty($user)) {
        if (isAuth()) {
            $user = authUser();
        }
    }
    return empty($user) ? false : Hash::check($password, $user->password);
}

function methodParam($method)
{
    return '_method=' . $method;
}

function localeInputId($name, $locale)
{
    return $name . '_' . $locale;
}

function oldLocaleInput($name, $locale, $default = null)
{
    return old(AppConfig::KEY_LOCALE_INPUT . '.' . $locale . '.' . $name, $default);
}

function localeInputName($name, $locale, $isArray = false, $indexKey = null)
{
    $name = AppConfig::KEY_LOCALE_INPUT . '[' . $locale . '][' . $name . ']';
    if ($isArray) {
        $name .= empty($indexKey) ? '[]' : '[' . $indexKey . ']';
    }
    return $name;
}

function parseEmbedVideoUrl($videoUrl)
{
    if (preg_match(AppConfig::REGEX_YOUTUBE_URL, $videoUrl, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[4];
    } elseif (preg_match(AppConfig::REGEX_VIMEO_URL, $videoUrl, $matches)) {
        return 'https://player.vimeo.com/video/' . $matches[3];
    } elseif (preg_match(AppConfig::REGEX_DAILYMOTION_URL, $videoUrl, $matches)) {
        return 'http://www.dailymotion.com/embed/video/' . (empty($matches[4]) ? $matches[6] : $matches[4]);
    } else return null;
}

function parseTitleOfUrl($url)
{
    $content = @file_get_contents($url);
    if (strlen($content) > 0) {
        $content = trim(preg_replace('/\s+/', ' ', $content)); // supports line breaks inside <title>
        if (preg_match('/\<title\>(.*)\<\/title\>/i', $content, $titles)) {
            return $titles[1];
        }
    }

    return '';
}

function wrapContent($content, $before = '', $after = '', $default = '')
{
    return empty($content) ? $default : $before . $content . $after;
}

function pnl2br($text)
{
    return empty($text) ? '' : '<p>' . nl2br($text) . '</p>';
}

function pnl2p($text)
{
    return empty($text) ? '' : '<p>' . preg_replace('/\r*\n/', '</p><p>', $text) . '</p>';
}

/**
 * @param string $input
 * @param int $length
 * @return string
 */
function shorten($input, $length = AppConfig::DEFAULT_SHORTEN_TEXT_LENGTH)
{
    $input = trim($input);
    return htmlspecialchars(trim(str_replace(["&nbsp;", "\r\n", "\n", "\r"], ' ', Str::limit($input, $length))), ENT_QUOTES);
}

/**
 * @param $input
 * @param int $length
 * @return string
 */
function htmlShorten($input, $length = AppConfig::DEFAULT_SHORTEN_TEXT_LENGTH)
{
    $input = trim($input);
    return htmlspecialchars(trim(str_replace(["&nbsp;", "\r\n", "\n", "\r"], ' ', Str::limit(strip_tags($input), $length))), ENT_QUOTES);
}

/**
 * @param string|array $input
 * @return string
 */
function escapeHtml($input)
{
    if (is_array($input)) {
        foreach ($input as &$item) {
            $item = escapeHtml($item);
        }
        return $input;
    }
    return htmlspecialchars(trim(str_replace(['&nbsp;', "\r\n", "\n", "\r"], ' ', strip_tags($input))), ENT_QUOTES);
}

function extractImageUrls($fromString)
{
    if (preg_match_all('/https?:\/\/[^ ]+?(?:\.jpg|\.png|\.gif)/', $fromString, $urls) !== false) {
        return $urls[0];
    }
    return [];
}

function escapeEmoticons($text, $forExporting = true)
{
    $string = preg_replace('/([0-9|#][\x{20E3}])|[\x{00ae}|\x{00a9}|\x{203C}|\x{2047}|\x{2048}|\x{2049}|\x{3030}|\x{303D}|\x{2139}|\x{2122}|\x{3297}|\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F6FF}][\x{FE00}-\x{FEFF}]?/u', '', $text);
    if ($forExporting) {
        $string = preg_replace('/^\=+/', '', $string);
    }

    return $string;
}

/**
 * @param string $input
 * @param string $append
 * @param string $prepend
 * @return string
 */
function toSlug($input, $append = '', $prepend = '')
{
    $slug = Str::slug($input);
    if (!empty($append)) {
        $slug .= '-' . Str::slug($append);
    }
    if (!empty($prepend)) {
        $slug = Str::slug($prepend) . '-' . $slug;
    }
    return $slug;
}

/**
 * @param string $haystack
 * @param array|string $needle
 * @return bool
 */
function beginsWith($haystack, $needle)
{
    return Str::startsWith($haystack, $needle);
}

function vietnameseToRoman($str)
{
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    return $str;
}

/**
 * @param int $number
 * @return string
 */
function toFormattedInt($number)
{
    $helper = NumberFormatHelper::getInstance();
    $helper->modeInt();
    $number = $helper->format($number);
    $helper->modeNormal();
    return $number;
}

/**
 * @param float $number
 * @param int $mode
 * @return string
 */
function toFormattedNumber($number, $mode = NumberFormatHelper::DEFAULT_NUMBER_OF_DECIMAL_POINTS)
{
    $helper = NumberFormatHelper::getInstance();
    $helper->mode($mode);
    $number = $helper->format($number);
    $helper->modeNormal();
    return $number;
}

/**
 * @param float $number
 * @param string $originalCurrencyCode
 * @param int $mode
 * @return string
 */
function toFormattedCurrency($number, $originalCurrencyCode = null, $noSign = false, $mode = NumberFormatHelper::DEFAULT_NUMBER_OF_DECIMAL_POINTS)
{
    $helper = NumberFormatHelper::getInstance();
    $helper->mode($mode);
    $number = $helper->formatCurrency($number, $originalCurrencyCode, $noSign);
    $helper->modeNormal();
    return $number;
}

/**
 * @param string $formattedNumber
 * @return int
 */
function fromFormattedInt($formattedNumber)
{
    $helper = NumberFormatHelper::getInstance();
    $helper->modeInt();
    $number = $helper->fromFormat($formattedNumber);
    $helper->modeNormal();
    return (int)$number;
}

/**
 * @param string $formattedNumber
 * @return float
 */
function fromFormattedNumber($formattedNumber, $mode = NumberFormatHelper::DEFAULT_NUMBER_OF_DECIMAL_POINTS)
{
    $helper = NumberFormatHelper::getInstance();
    $helper->mode($mode);
    $number = $helper->fromFormat($formattedNumber);
    $helper->modeNormal();
    return $number;
}

/**
 * @param string $formattedCurrency
 * @param string $originalCurrencyCode
 * @return float
 */
function fromFormattedCurrency($formattedCurrency, $originalCurrencyCode = null, $mode = NumberFormatHelper::DEFAULT_NUMBER_OF_DECIMAL_POINTS)
{
    $helper = NumberFormatHelper::getInstance();
    $helper->mode($mode);
    $number = $helper->fromFormatCurrency($formattedCurrency);
    $helper->modeNormal();
    return $number;
}

#region Colors
function rgbToHex($rgb = [])
{
    if (!is_array($rgb) || count($rgb) != 3) {
        $rgb = [rand(0, 255), rand(0, 255), rand(0, 255)];
    }
    $hex[0] = str_pad(dechex($rgb[0]), 2, '0', STR_PAD_LEFT);
    $hex[1] = str_pad(dechex($rgb[1]), 2, '0', STR_PAD_LEFT);
    $hex[2] = str_pad(dechex($rgb[2]), 2, '0', STR_PAD_LEFT);
    return implode('', $hex);
}

function randomColorToHex()
{
    return rgbToHex([random_int(0, 255), random_int(0, 255), random_int(0, 255),]);
}

#endregion

#endregion

#region Configuration Helper
function allGenders()
{
    return config('katniss.genders');
}

function allCountries()
{
    return config('katniss.countries');
}

function allCountryCodes()
{
    return array_keys(allCountries());
}

function allCountry($code, $property = '')
{
    $countries = allCountries();
    if (empty($countries[$code])) return null;
    return empty($property) || $property == 'all' ? $countries[$code] : $countries[$code][$property];
}

function allNumberFormats()
{
    return config('katniss.number_formats');
}

function allCurrencies()
{
    return config('katniss.currencies');
}

function allCurrencyCodes()
{
    return array_keys(allCurrencies());
}

function allCurrency($code, $property = '')
{
    $currencies = allCurrencies();
    if (empty($currencies[$code])) return null;
    return empty($property) || $property == 'all' ? $currencies[$code] : $currencies[$code][$property];
}

#endregion

#region Trans Helper
function transGender($genderIndex)
{
    $genders = _k('genders');
    return empty($genderIndex) ?
        '' : trans('label.gender_' . $genders[intval($genderIndex) - 1]);
}

function transMonthYear($dateString, $hideCurrentYear = true)
{
    $time = strtotime($dateString);
    $year = date('Y', $time);
    $return = trans('datetime.month_' . date('n', $time));
    return $return . ($hideCurrentYear && $year == date('Y') ? '' : ', ' . $year);
}

#endregion

#region Options Helper
function countriesAsOptions($selected_country = 'VN')
{
    $options = '';
    foreach (allCountries() as $code => $properties) {
        $options .= '<option value="' . $code . '"' . ($selected_country == $code ? ' selected' : '') . '>' . $properties['name'] . '</option>';
    }
    return $options;
}

function callingCodesAsOptions($selected_country = 'VN')
{
    $options = '';
    foreach (allCountries() as $code => $properties) {
        $options .= '<option value="' . $code . '"' . ($selected_country == $code ? ' selected' : '') . '>(+' . $properties['calling_code'] . ') ' . $properties['name'] . '</option>';
    }
    return new HtmlString($options);
}

function currenciesAsOptions($selected_currency = 'VND')
{
    $options = '';
    foreach (allCurrencies() as $code => $properties) {
        $options .= '<option value="' . $code . '"' . ($selected_currency == $code ? ' selected' : '') . '>' . $properties['name'] . ' (' . $properties['symbol'] . ')' . '</option>';
    }
    return $options;
}

function numberFormatsAsOptions($selected_number_format = 'point-comma')
{
    $options = '';
    foreach (allNumberFormats() as $number_format) {
        $options .= '<option value="' . $number_format . '"' . ($selected_number_format == $number_format ? ' selected' : '') . '>' . NumberFormatHelper::doFormat(12345.67, $number_format) . '</option>';
    }
    return $options;
}

function timeZoneListAsOptions($selected)
{
    return DateTimeHelper::getTimeZoneListAsOptions($selected);
}

function daysOfWeekAsOptions($selected)
{
    return DateTimeHelper::getDaysOfWeekAsOptions($selected);
}

function longDateFormatsAsOptions($selected)
{
    return DateTimeHelper::getLongDateFormatsAsOptions($selected);
}

function shortDateFormatsAsOptions($selected)
{
    return DateTimeHelper::getShortDateFormatsAsOptions($selected);
}

function longTimeFormatsAsOptions($selected)
{
    return DateTimeHelper::getLongTimeFormatsAsOptions($selected);
}

function shortTimeFormatsAsOptions($selected)
{
    return DateTimeHelper::getShortTimeFormatsAsOptions($selected);
}

#endregion