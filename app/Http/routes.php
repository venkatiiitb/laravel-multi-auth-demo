<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// App Default Route
Route::get('/', function () {
    return view('welcome');
});

// Normal User Auth Routes
Route::auth();

// Landing Page Route
Route::get('/home', 'HomeController@index');

// Login Routes...
Route::get('/admin/login','AdminAuth\AuthController@showLoginForm');
Route::post('/admin/login','AdminAuth\AuthController@login');

// Password Reset Routes...
$this->get('/admin/password/reset/{token?}', 'AdminAuth\PasswordController@showResetForm');
$this->post('/admin/password/email', 'AdminAuth\PasswordController@sendResetLinkEmail');
$this->post('/admin/password/reset', 'AdminAuth\PasswordController@reset');

// Registration Routes...
Route::get('/admin/register', 'AdminAuth\AuthController@showRegistrationForm');
Route::post('/admin/register', 'AdminAuth\AuthController@register');

// Facebook Auth Routes
Route::get('/redirect/{provider}', 'SocialAuthController@redirect');
Route::get('/callback/{provider}', 'SocialAuthController@callback');

// Admin Post Auth Routes
Route::group(['middleware' => ['admin']], function () {

    //Login Routes...
    Route::get('/admin/logout','AdminAuth\AuthController@logout');

    // admin dashboard page
    Route::get('/admin', 'AdminController@index');

});