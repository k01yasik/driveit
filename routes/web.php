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

use Illuminate\Support\Facades\Route;

Route::get('/', 'PageController@home')->name('page.home');

Route::group(['prefix' => 'user', 'middleware' => ['auth', 'public', 'verified']], function () {

    Route::post('/favorite/add', 'FavoriteController@vote')->name('user.favorite.image');

    Route::post('/friends/requests', 'UserPageController@update')->name('user.requests.confirmation');

    Route::get('/{username}', 'UserPageController@index')->name('user.profile');

    Route::get('/{username}/albums', 'UserAlbumsController@index')->name('user.albums.index');

    Route::get('/{username}/albums/{albumname}', 'UserAlbumsController@show')->name('user.albums.show');

    Route::post('/friends/add', 'PublicUsersController@store')->name('users.store');

    Route::get('/{username}/friends', 'UserPageController@friends')->name('user.friends');

    Route::group(['middleware' => 'current'], function () {

        Route::post('/messages/store', 'MessageController@store')->name('message.store');

        Route::delete('/image/delete', 'ImageUploadController@delete')->name('user.image.delete');

        Route::post('/image/upload', 'ImageUploadController@upload')->name('user.image.upload');

        Route::post('/avatar/upload', 'ImageUploadController@avatar')->name('user.avatar.upload');

        Route::post('/albums/image/upload', 'ImageUploadController@image')->name('user.albums.image.upload');

        Route::get('/{username}/settings', 'UserPageController@settings')->name('user.settings');

        Route::get('/{username}/friends/requests', 'UserPageController@requests')->name('user.requests');

        Route::get('/{username}/friends/add', 'PublicUsersController@index')->name('users');

        Route::get('/{username}/messages', 'UserPageController@messages')->name('user.messages');

        Route::get('/{username}/messages/{friend}', 'UserPageController@friendMessages')->name('user.friend.messages');

        Route::get('/{username}/comment/{id}/edit', 'CommentController@edit')->name('user.comment.edit');

        Route::get('/{username}/new/albums', 'UserAlbumsController@create')->name('user.albums.create');

        Route::post('/{username}/albums', 'UserAlbumsController@store')->name('user.albums.store');

        Route::get('/{username}/albums/{albumname}/edit', 'UserAlbumsController@edit')->name('user.albums.edit');

        Route::put('/{username}/albums/{albumname}', 'UserAlbumsController@update')->name('user.albums.update');

    });

});

Route::get('/best-rated', 'PageController@list')->name('posts.rated');

Route::get('/best-rated/page/{id}', 'PageController@ratedPaginate')->name('best.rated.paginate');

Route::get('/best-views', 'PageController@list')->name('posts.views');

Route::get('/best-views/page/{id}', 'PageController@viewsPaginate')->name('best.views.paginate');

Route::get('/best-comments', 'PageController@list')->name('posts.comments');

Route::get('/best-comments/page/{id}', 'PageController@commentsPaginate')->name('best.comments.paginate');

Route::get('/about', 'PageController@about')->name('page.about');

Route::get('/rules', 'PageController@rules')->name('page.rules');

Route::post('/comment/store', 'CommentController@store')->name('comment.store');

Route::group(['prefix' => 'admin', 'middleware' => 'role:admin'], function () {

    Route::post('/token/create', 'AdminAirlockController@create')->name('admin.token.create');

    Route::get('/', 'AdminController@index')->name('admin.index');

    Route::get('/users', 'AdminController@users')->name('admin.users');

    Route::get('/users/verified', 'AdminController@verified')->name('admin.verified');

    Route::get('/users/unverified', 'AdminController@unverified')->name('admin.unverified');

    Route::get('/users/banned', 'AdminController@banned')->name('admin.banned');

    Route::get('/user/{username}', 'AdminController@show')->name('admin.user.show');

    Route::get('/user/{username}/delete', 'AdminController@delete')->name('admin.user.delete');

    Route::post('/rips', 'RipController@store')->name('admin.user.ban');

    Route::delete('/rips', 'RipController@destroy')->name('admin.user.unban');

    Route::get('/posts', 'AdminController@posts')->name('admin.posts');

    Route::get('/posts/page/{id}', 'AdminController@paginate')->name('admin.posts.paginate');

    Route::post('/posts/image-upload', 'ImageUploadController@index')->name('admin.posts.image.upload');

    Route::delete('/posts/image-destroy', 'ImageUploadController@destroy')->name('admin.posts.image.destroy');

    Route::get('/comments', 'AdminController@comments')->name('admin.comments');

    Route::get('/comments/page/{id}', 'AdminController@commentsPaginate')->name('admin.comments.paginate');

    Route::put('/comments/publish', 'AdminCommentController@publish')->name('admin.comments.publish');

    Route::get('/comments/unpublished', 'AdminController@unpublished')->name('admin.comments.unpublished');

    Route::get('/seo', 'SeoController@index')->name('admin.seo');

    Route::post('/seo', 'SeoController@store')->name('seo.store');

    Route::get('/seo/create', 'SeoController@create')->name('seo.create');

    Route::get('/seo/{id}', 'SeoController@show')->name('seo.show');

    Route::get('/seo/{id}/edit', 'SeoController@edit')->name('seo.edit');

    Route::put('/seo/{id}', 'SeoController@update')->name('seo.update');

    Route::delete('/seo/{id}', 'SeoController@destroy')->name('seo.destroy');

    Route::get('/comments/{id}/edit', 'AdminCommentController@edit')->name('admin.comment.edit');

    Route::get('/posts/create', 'PostController@create')->name('admin.posts.create');

    Route::post('/posts', 'PostController@store')->name('admin.posts.store');

    Route::get('/posts/{id}/edit', 'PostController@edit')->name('admin.posts.edit');

    Route::get('/posts/{id}/edit/html', 'PostController@editHtml')->name('admin.posts.html');

    Route::put('/posts/publish', 'PostController@publish')->name('admin.posts.publish');

    Route::put('/posts/html/{id}', 'PostController@updateHtml')->name('admin.posts.html.update');

    Route::put('/posts/{id}', 'PostController@update')->name('admin.posts.update');

    Route::get('/posts/{id}', 'PostController@show')->name('admin.posts.show');

    Route::get('/news/create', 'NewsController@create')->name('news.create');

    Route::post('/news', 'NewsController@store')->name('news.store');

    Route::get('/news/{id}/edit', 'NewsController@edit')->name('news.edit');

    Route::put('/news/{id}', 'NewsController@update')->name('news.update');

    Route::delete('/news/{id}', 'NewsController@delete')->name('news.delete');

    Route::get('/news/{id}/toggle', 'NewsController@publishToggle')->name('news.toggle');

});

Route::get('/amp/{slug}', 'AmpController@show')->name('amp.show');

Route::get('/category/{category}', 'CategoryController@show')->name('category.show');

Route::get('/category/{category}/page/{id}', 'CategoryController@paginate')->name('category.paginate');

Route::get('/posts', 'PageController@index')->name('posts.index');

Route::get('/posts/page/{id}', 'PageController@paginate')->name('posts.paginate');

Route::get('/posts/{slug}', 'PageController@show')->name('posts.show');

Route::post('/rating/post', 'RatingController@update')->name('rating.post');

Route::get('/search', 'SearchController@index')->name('search.index');

Route::get('/news', 'NewsController@index')->name('news.index');

Route::get('login/facebook', 'Auth\LoginController@redirectToProviderFacebook')->name('login.facebook');

Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallbackFacebook');

Route::get('login/google', 'Auth\LoginController@redirectToProviderGoogle')->name('login.google');

Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallbackGoogle');

Route::get('turbo.rss', 'TurboController@index');

Route::get('sitemap.xml', 'SitemapController@index');

Auth::routes(['verify' => true]);

Route::fallback('PageController@notFound');

//Broadcast::routes();