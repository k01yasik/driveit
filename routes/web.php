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


Route::get('/', 'PageController@home')->name('home');

Route::get('/users', 'PublicUsersController@index')->name('users');

Route::get('/user/{username}', 'UserPageController@index')->name('user.page');

Route::get('/user/{username}/settings', 'UserPageController@settings')->name('user.settings');

Route::get('/user/{username}/friends', 'UserPageController@friends')->name('user.friends');

Route::get('/user/{username}/messages', 'UserPageController@messages')->name('user.messages');

Route::get('/user/{username}/messages/{friend}', 'UserPageController@friendMessages')->name('user.friend.messages');

Auth::routes();