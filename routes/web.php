<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();
Route::get('login/{provider}', ['as' => 'oauth.redirect', 'uses' => 'Auth\OAuthController@handleProviderRequest']);
Route::get('login/{provider}/callback',
    ['as' => 'oauth.callback', 'uses' => 'Auth\OAuthController@handleProviderCallback']);

Route::get('/', 'HomeController@index')->name('home');
Route::get('search', 'HomeController@search')->name('search');

Route::resource('products', 'ProductsController');
Route::resource('categories', 'CategoriesController');
Route::resource('statistics', 'StatisticsController');
