<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    /**
     * Unauthenticated routes
     */
    Route::post('auth/login', 'Auth\LoginController@login');
    Route::post('auth/register', 'Auth\RegisterController@create');
    Route::post('auth/password/forgot', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('auth/password/reset', 'Auth\ResetPasswordController@reset');

    Route::get('ping', 'UtilityController@ping');
    Route::get('log-ping', 'UtilityController@logPing');

    /**
     * Authenticated routes
     */
    Route::middleware('auth:api')->group(function () {
        Route::post('auth/logout', 'Auth\LoginController@logout');

        Route::get('me', 'UserController@getMe');
        Route::match(['put', 'patch'], 'me', 'UserController@updateMe');
    });
});
