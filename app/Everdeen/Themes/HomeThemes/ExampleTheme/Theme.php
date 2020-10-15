<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-12-07
 * Time: 02:53
 */

namespace Katniss\Everdeen\Themes\HomeThemes\ExampleTheme;

use Katniss\Everdeen\Themes\HomeThemes\HomeTheme;
use Katniss\Everdeen\Themes\Queue\CssQueue;
use Katniss\Everdeen\Themes\Queue\JsQueue;

class Theme extends HomeTheme
{
    const NAME = 'example';
    const DISPLAY_NAME = 'Example Theme';
    const VIEW = 'example';

    public function __construct()
    {
        parent::__construct();
    }

    public function mockAdmin()
    {
    }

    public function register($isAuth = false)
    {
        parent::register($isAuth);
    }

    protected function registerComposers($is_auth = false)
    {
    }

    protected function registerLibStyles($is_auth = false)
    {
        parent::registerLibStyles($is_auth);

        $this->libCssQueue->add(CssQueue::LIB_BOOTSTRAP_NAME, $this->cssAsset('bootstrap.min.css'));
        $this->libCssQueue->add(CssQueue::LIB_FONT_AWESOME_NAME, _kExternalLink(CssQueue::LIB_FONT_AWESOME_NAME));
    }

    protected function registerExtStyles($is_auth = false)
    {
        $this->extCssQueue->add('theme-style', $this->cssAsset('scrolling-nav.css'));

        parent::registerExtStyles($is_auth);
    }

    protected function registerLibScripts($is_auth = false)
    {
        parent::registerLibScripts($is_auth);

        $this->libJsQueue->add(JsQueue::LIB_JQUERY_NAME, $this->jsAsset('jquery.js'));
        $this->libJsQueue->add(JsQueue::LIB_BOOTSTRAP_NAME, $this->jsAsset('bootstrap.min.js'));
        $this->libJsQueue->add('jquery-easing', $this->jsAsset('jquery.easing.min.js'));
    }

    protected function registerExtScripts($is_auth = false)
    {
        $this->extJsQueue->add('theme-script', $this->jsAsset('scrolling-nav.js'));

        parent::registerExtScripts($is_auth);
    }

    public function extensions()
    {
        return [
            // define extension here: extension name => extension class
        ];
    }
}