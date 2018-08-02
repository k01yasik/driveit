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

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
    Route::get('/{username}', 'UserPageController@index')->name('user.page');

    Route::get('/{username}/settings', 'UserPageController@settings')->name('user.settings');

    Route::get('/{username}/friends', 'UserPageController@friends')->name('user.friends');

    Route::get('/{username}/messages', 'UserPageController@messages')->name('user.messages');

    Route::get('/{username}/messages/{friend}', 'UserPageController@friendMessages')->name('user.friend.messages');

    Route::get('/{username}/comment/{id}/edit', 'CommentController@edit')->name('user.comment.edit');

    Route::get('/{username}/albums', 'UserAlbumsController@index')->name('user.albums.index');

    Route::get('/{username}/albums/create', 'UserAlbumsController@create')->name('user.albums.create');

    Route::get('/{username}/albums/{albumname}', 'UserAlbumsController@show')->name('user.albums.show');

    Route::get('/{username}/albums/{albumname}/edit', 'UserAlbumsController@update')->name('user.albums.edit');
});

Route::get('/users', 'PublicUsersController@index')->name('users');

Route::get('/tags/{tag}', 'TagsController@show')->name('tags.show');

Route::get('/top-rated', 'PageController@list')->name('posts.top');

Route::get('/best-views', 'PageController@list')->name('posts.best');

Route::get('/best-comments', 'PageController@list')->name('posts.comments');

Route::get('/about', 'PageController@about')->name('page.about');

Route::get('/rules', 'PageController@rules')->name('page.rules');

Route::group(['prefix' => 'admin', 'middleware' => 'role:admin'], function () {

    Route::get('/', 'AdminController@index')->name('admin.index');

    Route::get('/users', 'AdminController@users')->name('admin.users');

    Route::get('/posts', 'AdminController@posts')->name('admin.posts');

    Route::get('/comments', 'AdminController@comments')->name('admin.comments');

    Route::get('/seo', 'AdminController@seo')->name('admin.seo');

    Route::get('/seo/create', 'SeoController@create')->name('seo.create');

    Route::get('/seo/{id}', 'SeoController@show')->name('seo.show');

    Route::get('/seo/{id}/edit', 'SeoController@edit')->name('seo.edit');

    Route::get('/comments/{id}/edit', 'AdminCommentController@edit')->name('admin.comment.edit');

    Route::get('/posts/create', 'PostController@create')->name('admin.posts.create');

    Route::get('/posts/{id}/edit', 'PostController@edit')->name('admin.posts.edit');

});

Route::get('/posts/{slug}', 'PageController@post')->name('posts.show');

Auth::routes();