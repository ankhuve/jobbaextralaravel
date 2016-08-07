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

Route::get('/', 'HomeController@index');

Route::get('about', 'AboutController@index');
Route::get('contact', 'ContactController@create');
Route::post('contact', 'ContactController@store');
//Route::get('featured', 'FeaturedController@index');
Route::get('company', 'CompanyController@index');
Route::get('company/create', 'CompanyController@show');
Route::post('company/create', 'CompanyController@create');
Route::get('company/create/confirm', 'CompanyController@confirm');
Route::get('register', 'RegisterController@index');
//Route::get('search/{keyword?}', 'SearchController@index');
Route::get('search', 'SearchController@index');
Route::get('getJobInfo/{jobid}', 'JobController@getJob');
Route::get('job/{id}/{slug}', 'JobController@customJob');
Route::get('job/{id}', 'JobController@index');

// uncaught route
Route::get('{any}', function(){
	return(redirect(URL::action('HomeController@index')));
});

// Auth routes
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::resource('company', 'CompanyController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
