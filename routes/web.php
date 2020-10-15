<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localize']
], function () {
    Route::any(homeRoute('extra'), 'ViewController@extra');

    Route::get(homeRoute('errors/{code}'), 'ViewController@error');
    Route::get(adminRoute('errors/{code}'), 'ViewController@error');

    Route::group([
        'namespace' => 'Home',
    ], function () {
        Route::get('/', 'ExampleController@index');
    });

    Route::get(homeRoute('me/settings'), 'Admin\SettingsController@index');
    Route::put(homeRoute('me/settings'), 'Admin\SettingsController@update');

    Route::group([
        'namespace' => 'Auth',
    ], function () {
        Route::get(homeRoute('auth/login'), 'LoginController@showLoginForm')->name('login');
        Route::post(homeRoute('auth/login'), 'LoginController@login');
        Route::get(homeRoute('auth/logout'), 'LoginController@logout');
        Route::get(homeRoute('auth/activate/{id}/{activation_code}'), 'ActivateController@getActivation')->where('id', '[0-9]+');
        Route::get(homeRoute('auth/inactive'), 'ActivateController@getInactive');
        Route::post(homeRoute('auth/inactive'), 'ActivateController@postInactive');
    });

    Route::group([
        'middleware' => 'auth'
    ], function () {
        Route::any(adminRoute('extra'), 'ViewController@extra');
        // my account
        Route::get(homeRoute('me/account'), 'Admin\AccountController@index');
        Route::put(homeRoute('me/account'), 'Admin\AccountController@update');

        #region Admin Role
        Route::group([
            'namespace' => 'Admin',
            'middleware' => 'entrust:,access-admin'
        ], function () {
            Route::get(homeRoute('admin'), 'DashboardController@index');

            Route::group([
                'middleware' => 'entrust:admin'
            ], function () {
                Route::any(adminRoute('extra'), 'ViewController@extra');
                //App Options
                Route::get(adminRoute('app-options'), 'AppOptionController@index');
                Route::get(adminRoute('app-options/{id}/edit'), 'AppOptionController@edit')->where('id', '[0-9]+');
                Route::put(adminRoute('app-options/{id}'), 'AppOptionController@update')->where('id', '[0-9]+');
                Route::delete(adminRoute('app-options/{id}'), 'AppOptionController@destroy')->where('id', '[0-9]+');
                //Extensions
                Route::get(adminRoute('extensions'), 'ExtensionController@index');
                Route::get(adminRoute('extensions/{name}/edit'), 'ExtensionController@edit');
                Route::put(adminRoute('extensions/{name}'), 'ExtensionController@update');
                //Languages
                Route::get(adminRoute('ui-lang/php'), 'UiLangController@editPhp');
                Route::put(adminRoute('ui-lang/php'), 'UiLangController@updatePhp');
                Route::get(adminRoute('ui-lang/email'), 'UiLangController@editEmail');
                Route::put(adminRoute('ui-lang/email'), 'UiLangController@updateEmail');
                //Passport Clients
                Route::get(adminRoute('passport-clients'), 'PassportClientController@index');
            });
        });
        #endregion
    });
});