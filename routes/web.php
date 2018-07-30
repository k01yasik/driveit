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


Route::get('/', 'PageController@home')->name('page.home');

Route::get('/users', 'PublicUsersController@index')->name('users');

Route::get('/user/{username}', 'UserPageController@index')->name('user.page');

Route::get('/user/{username}/settings', 'UserPageController@settings')->name('user.settings');

Route::get('/user/{username}/friends', 'UserPageController@friends')->name('user.friends');

Route::get('/user/{username}/messages', 'UserPageController@messages')->name('user.messages');

Route::get('/user/{username}/messages/{friend}', 'UserPageController@friendMessages')->name('user.friend.messages');

Route::get('/user/{username}/comment/{id}/edit', 'CommentController@edit')->name('user.comment.edit');

Route::get('/user/{username}/albums', 'UserAlbumsController@index')->name('user.albums.index');

Route::get('/user/{username}/albums/create', 'UserAlbumsController@create')->name('user.albums.create');

Route::get('/user/{username}/albums/{albumname}', 'UserAlbumsController@show')->name('user.albums.show');

Route::get('/user/{username}/albums/{albumname}/edit', 'UserAlbumsController@update')->name('user.albums.edit');

Route::get('/tags/{tag}', 'TagsController@show')->name('tags.show');

Route::get('/top-rated', 'PageContoller@list')->name('posts.top');

Route::get('/best-views', 'PageController@list')->name('posts.best');

Route::get('/best-comments', 'PageController@list')->name('posts.comments');

Route::get('/about', 'PageController@about')->name('page.about');

Route::get('/rules', 'PageController@rules')->name('page.rules');

Route::get('/admin', 'AdminController@index')->name('admin.index');

Route::get('/admin/users', 'AdminController@users')->name('admin.users');

Route::get('/admin/posts', 'AdminController@posts')->name('admin.posts');

Route::get('/admin/comments', 'AdminController@comments')->name('admin.comments');

Route::get('/admin/seo', 'AdminController@seo')->name('admin.seo');

Route::get('/admin/seo/create', 'SeoController@create')->name('seo.create');

Route::get('/admin/seo/{id}', 'SeoController@show')->name('seo.show');

Route::get('/admin/seo/{id}/edit', 'SeoController@edit')->name('seo.edit');

Route::get('/admin/comments/{id}/edit', 'CommentController@adminedit')->name('admin.comment.edit');

Auth::routes();