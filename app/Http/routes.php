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

Route::get('om-oss', 'AboutController@index');

Route::get('kontakt', 'ContactController@create');
Route::post('kontakt', 'ContactController@store');

Route::get('arbetsgivare', 'FeaturedController@index');
Route::get('arbetsgivare/{id}', 'FeaturedController@featured');

Route::get('foretag', 'CompanyController@index');
Route::get('foretag/skapa', 'CompanyController@show');
Route::post('foretag/skapa', 'CompanyController@create');
Route::post('foretag/skapa/confirm', 'CompanyController@confirm');
Route::post('foretag/skapa/store', 'CompanyController@store');

Route::get('registrera', 'RegisterController@index');
//Route::get('search/{keyword?}', 'SearchController@index');
Route::get('hitta', 'SearchController@index');

Route::get('getJobInfo/{jobid}', 'JobController@getJob');
Route::get('jobb/{id}/{slug}', 'JobController@customJob');
Route::get('jobb/{id}', 'JobController@index');
Route::post('jobb/{id}/{slug?}/apply', 'JobController@apply');
Route::get('ansok/{id}', 'JobController@redirectToApplicationURL');

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

//Route::resource('foretag', 'CompanyController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
