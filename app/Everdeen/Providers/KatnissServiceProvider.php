<?php

namespace Katniss\Everdeen\Providers;

use Illuminate\Support\ServiceProvider;
use Katniss\Everdeen\Utils\DateTimeHelper;
use Katniss\Everdeen\Utils\Settings;
use Katniss\Everdeen\Utils\Storage\StoreFile;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Database\Connectors\ConnectionFactory;
use Katniss\Everdeen\Vendors\Laravel\Framework\Illuminate\Notifications\ChannelManager;
use Katniss\Everdeen\Vendors\Mcamara\LaravelLocalization\LaravelLocalization;

class KatnissServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        validator()->extend('password', function ($attribute, $value, $parameters) {
            return isMatchedUserPassword($value);
        });
        validator()->extend('wizard', function ($attribute, $value, $parameters) {
            return isValidWizardKey($value, $parameters[0]);
        });

        validator()->extend(
            'recaptcha',
            'Katniss\Everdeen\Validators\ReCaptcha@validate'
        );

        DateTimeHelper::syncNow(true);
        StoreFile::init();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->alias('request', \Katniss\Everdeen\Http\Request::class);

        $this->app->singleton('db.factory', function ($app) {
            return new ConnectionFactory($app);
        });

        $this->app->singleton(\Illuminate\Notifications\ChannelManager::class, function ($app) {
            return new ChannelManager($app);
        });

        $this->app->singleton('laravellocalization', function () {
            return new LaravelLocalization();
        });

        $this->app->singleton('settings', function () {
            return new Settings();
        });
    }
}
