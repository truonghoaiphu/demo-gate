<?php
Route::group([
    'namespace' => '\Laravel\Passport\Http\Controllers',
    'middleware' => 'cors.error',
], function () {
    Route::group(['middleware' => ['oauth', 'auth']], function () {
        Route::get('/authorize', [
            'uses' => 'AuthorizationController@authorize',
        ]);

        Route::post('/authorize', [
            'uses' => 'ApproveAuthorizationController@approve',
        ]);

        Route::delete('/authorize', [
            'uses' => 'DenyAuthorizationController@deny',
        ]);
    });

    Route::post('/token', [
        'uses' => 'AccessTokenController@issueToken',
        'middleware' => 'throttle'
    ]);

    Route::group(['middleware' => ['oauth', 'auth']], function () {
        Route::get('/tokens', [
            'uses' => 'AuthorizedAccessTokenController@forUser',
        ]);

        Route::delete('/tokens/{token_id}', [
            'uses' => 'AuthorizedAccessTokenController@destroy',
        ]);
    });

    Route::post('/token/refresh', [
        'middleware' => ['oauth', 'auth'],
        'uses' => 'TransientTokenController@refresh',
    ]);

    Route::group(['middleware' => ['oauth', 'auth']], function () {
        Route::get('/clients', [
            'uses' => 'ClientController@forUser',
        ]);

        Route::post('/clients', [
            'uses' => 'ClientController@store',
        ]);

        Route::put('/clients/{client_id}', [
            'uses' => 'ClientController@update',
        ]);

        Route::delete('/clients/{client_id}', [
            'uses' => 'ClientController@destroy',
        ]);
    });

    Route::group(['middleware' => ['oauth', 'auth']], function () {
        Route::get('/scopes', [
            'uses' => 'ScopeController@all',
        ]);

        Route::get('/personal-access-tokens', [
            'uses' => 'PersonalAccessTokenController@forUser',
        ]);

        Route::post('/personal-access-tokens', [
            'uses' => 'PersonalAccessTokenController@store',
        ]);

        Route::delete('/personal-access-tokens/{token_id}', [
            'uses' => 'PersonalAccessTokenController@destroy',
        ]);
    });
});

Route::get('/logout', 'Auth\VirtualAccountPassportController@logout');