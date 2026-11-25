<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AmpController,
    FavoriteController,
    PageController,
    UserPageController,
    UserAlbumsController,
    PublicUsersController,
    MessageController,
    ImageUploadController,
    CommentController,
    DraftController,
    AdminController,
    RipController,
    AdminCommentController,
    PostController,
    NewsController,
    SeoController,
    CategoryController,
    RatingController,
    SearchController,
    TurboController,
    SitemapController,
    Auth\LoginController
};

// Главные страницы
Route::get('/', [PageController::class, 'home'])->name('page.home');
Route::get('/about', [PageController::class, 'about'])->name('page.about');
Route::get('/rules', [PageController::class, 'rules'])->name('page.rules');

// Лучший контент
Route::prefix('best')->group(function () {
    Route::get('/rated', [PageController::class, 'bestRated'])->name('posts.rated');
    Route::get('/rated/page/{id}', [PageController::class, 'ratedPaginate'])->where('id', '[1-9][0-9]*')->name('best.rated.paginate');
    Route::get('/views', [PageController::class, 'bestViews'])->name('posts.views');
    Route::get('/views/page/{id}', [PageController::class, 'viewsPaginate'])->where('id', '[1-9][0-9]*')->name('best.views.paginate');
    Route::get('/comments', [PageController::class, 'bestComments'])->name('posts.comments');
    Route::get('/comments/page/{id}', [PageController::class, 'commentsPaginate'])->where('id', '[1-9][0-9]*')->name('best.comments.paginate');
    Route::get('/of-the-month-by-comments', [PageController::class, 'bestCommentsByMonth'])->name('best.comments.month');
});

// Посты и категории
Route::prefix('posts')->group(function () {
    Route::get('/', [PageController::class, 'index'])->name('posts.index');
    Route::get('/page/{id}', [PageController::class, 'paginate'])->where('id', '[1-9][0-9]*')->name('posts.paginate');
    Route::get('/{slug}', [PageController::class, 'show'])->name('posts.show');
});

Route::prefix('category/{category}')->group(function () {
    Route::get('/', [CategoryController::class, 'show'])->name('category.show');
    Route::get('/page/{id}', [CategoryController::class, 'paginate'])->where('id', '[1-9][0-9]*')->name('category.paginate');
});

// Аутентификация пользователей
Route::prefix('login')->group(function () {
    Route::get('/facebook', [LoginController::class, 'redirectToProviderFacebook'])->name('login.facebook');
    Route::get('/facebook/callback', [LoginController::class, 'handleProviderCallbackFacebook']);
    Route::get('/google', [LoginController::class, 'redirectToProviderGoogle'])->name('login.google');
    Route::get('/google/callback', [LoginController::class, 'handleProviderCallbackGoogle']);
});

Auth::routes(['verify' => true]);

// Пользовательские маршруты
Route::middleware(['auth', 'verified'])->prefix('user')->group(function () {
    // Профиль пользователя
    Route::get('/{username}', [UserPageController::class, 'index'])->middleware('public')->name('user.profile');
    Route::get('/{username}/settings', [UserPageController::class, 'settings'])->middleware('current')->name('user.settings');
    Route::patch('/{username}/settings', [UserPageController::class, 'updateSettings'])
        ->middleware('current')->name('user.settings.update');

    // Альбомы
    Route::middleware('public')->prefix('{username}/albums')->group(function () {
        Route::get('/', [UserAlbumsController::class, 'index'])->name('user.albums.index');

        Route::middleware('current')->group(function () {
            Route::get('/create', [UserAlbumsController::class, 'create'])->name('user.albums.create');
            Route::post('/', [UserAlbumsController::class, 'store'])->name('user.albums.store');
            Route::get('/{albumname}/edit', [UserAlbumsController::class, 'edit'])->name('user.albums.edit');
            Route::put('/{albumname}', [UserAlbumsController::class, 'update'])->name('user.albums.update');
        });

        Route::get('/{albumname}', [UserAlbumsController::class, 'show'])->name('user.albums.show');
    });

    // Избранное
    Route::post('/favorite/add', [FavoriteController::class, 'addFavorite'])->name('user.favorite.add');
    Route::post('/favorite/remove', [FavoriteController::class, 'removeFavorite'])->name('user.favorite.remove');

    // Друзья
    Route::prefix('friends')->group(function () {
        Route::get('/{username}', [UserPageController::class, 'friends'])->middleware('public')->name('user.friends');
        Route::post('/add', [PublicUsersController::class, 'store'])->name('users.store');
        Route::post('/requests', [UserPageController::class, 'update'])->name('user.requests.confirmation');

        Route::middleware('current')->group(function () {
            Route::get('/{username}/requests', [UserPageController::class, 'requests'])->name('user.requests');
            Route::get('/{username}/add', [PublicUsersController::class, 'index'])->name('users');
        });
    });

    // Сообщения
    Route::middleware('current')->prefix('{username}/messages')->group(function () {
        Route::get('/', [UserPageController::class, 'messages'])->name('user.messages');
        Route::get('/{friend}', [UserPageController::class, 'friendMessages'])->name('user.friend.messages');
        Route::post('/store', [MessageController::class, 'store'])->name('message.store');
    });

    // Черновики
    Route::get('/{username}/drafts', [DraftController::class, 'index'])->middleware('current')->name('draft.index');

    // Изображения
    Route::delete('/image/delete', [ImageUploadController::class, 'deleteImage'])->name('user.image.delete');
    Route::post('/image/upload', [ImageUploadController::class, 'uploadBodyImage'])->name('user.image.upload');
    Route::post('/avatar/upload', [ImageUploadController::class, 'uploadAvatar'])->name('user.avatar.upload');
    Route::post('/albums/image/upload', [ImageUploadController::class, 'uploadToAlbum'])->name('user.albums.image.upload');

    // Комментарии
    Route::middleware('current')->group(function () {
        Route::get('/{username}/comment/{comment}/edit', [CommentController::class, 'edit'])->whereNumber('comment')->name('user.comment.edit');
        Route::patch('/{username}/comment/{comment}', [CommentController::class, 'update'])->whereNumber('comment')->name('user.comment.update');
    });
});

// Админ панель
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    // Управление пользователями
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/verified', [AdminController::class, 'verified'])->name('admin.verified');
        Route::get('/unverified', [AdminController::class, 'unverified'])->name('admin.unverified');
        Route::get('/banned', [AdminController::class, 'banned'])->name('admin.banned');
        Route::get('/{username}', [AdminController::class, 'show'])->name('admin.user.show');
        Route::get('/{username}/delete', [AdminController::class, 'delete'])->name('admin.user.delete');
    });

    // Баны
    Route::prefix('rips')->group(function () {
        Route::post('/', [RipController::class, 'store'])->name('admin.user.ban');
        Route::delete('/', [RipController::class, 'destroy'])->name('admin.user.unban');
    });

    // Управление постами
    Route::prefix('posts')->group(function () {
        Route::get('/', [AdminController::class, 'posts'])->name('admin.posts');
        Route::get('/page/{id}', [AdminController::class, 'paginate'])->where('id', '[1-9][0-9]*')->name('admin.posts.paginate');
        Route::get('/create', [PostController::class, 'create'])->name('admin.posts.create');
        Route::post('/', [PostController::class, 'store'])->name('admin.posts.store');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('admin.posts.edit');
        Route::get('/{id}/edit/html', [PostController::class, 'editHtml'])->name('admin.posts.html');
        Route::put('/{id}/publish', [PostController::class, 'publish'])->whereNumber('id')->name('admin.posts.publish');
        Route::put('/{id}/unpublish', [PostController::class, 'unpublish'])->whereNumber('id')->name('admin.posts.unpublish');
        Route::put('/{id}/archive', [PostController::class, 'archive'])->whereNumber('id')->name('admin.posts.archive');
        Route::put('/{id}/restore', [PostController::class, 'restore'])->whereNumber('id')->name('admin.posts.restore');
        Route::put('/html/{id}', [PostController::class, 'updateHtml'])->name('admin.posts.html.update');
        Route::put('/{id}', [PostController::class, 'update'])->name('admin.posts.update');
        Route::get('/{id}', [PostController::class, 'show'])->name('admin.posts.show');

        // Изображения постов
        Route::post('/image-upload', [ImageUploadController::class, 'uploadPostImage'])->name('admin.posts.image.upload');
        Route::delete('/image-destroy', [ImageUploadController::class, 'deleteImage'])->name('admin.posts.image.destroy');
    });

    // Управление комментариями
    Route::prefix('comments')->group(function () {
        Route::get('/', [AdminController::class, 'comments'])->name('admin.comments');
        Route::get('/page/{id}', [AdminController::class, 'commentsPaginate'])->where('id', '[1-9][0-9]*')->name('admin.comments.paginate');
        Route::put('/publish', [AdminCommentController::class, 'publish'])->name('admin.comments.publish');
        Route::get('/unpublished', [AdminController::class, 'unpublished'])->name('admin.comments.unpublished');
        Route::get('/{comment}/edit', [AdminCommentController::class, 'edit'])->whereNumber('comment')->name('admin.comment.edit');
        Route::patch('/{comment}', [AdminCommentController::class, 'update'])->whereNumber('comment')->name('admin.comment.update');
    });

    // SEO
    Route::prefix('seo')->group(function () {
        Route::get('/', [SeoController::class, 'index'])->name('admin.seo');
        Route::get('/create', [SeoController::class, 'create'])->name('seo.create');
        Route::post('/', [SeoController::class, 'store'])->name('seo.store');
        Route::get('/{id}', [SeoController::class, 'show'])->name('seo.show');
        Route::get('/{id}/edit', [SeoController::class, 'edit'])->name('seo.edit');
        Route::put('/{id}', [SeoController::class, 'update'])->name('seo.update');
        Route::delete('/{id}', [SeoController::class, 'destroy'])->name('seo.destroy');
    });

    // Новости
    Route::prefix('news')->group(function () {
        Route::get('/', [NewsController::class, 'adminIndex'])->name('admin.news.index');
        Route::view('/create', 'news.create')->name('news.create');
        Route::post('/', [NewsController::class, 'store'])->name('news.store');
        Route::put('/{id}', [NewsController::class, 'update'])->name('news.update');
        Route::delete('/{id}', [NewsController::class, 'delete'])->name('news.delete');
        Route::patch('/{id}/toggle', [NewsController::class, 'publishToggle'])->name('news.toggle');
    });
});

Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->where('post', '[1-9][0-9]*');
    Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.store');
    Route::post('/rating/post', [RatingController::class, 'update'])->name('rating.post');
});

// Разное
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/amp/{slug}', [AmpController::class, 'show'])->name('amp.show');
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/turbo.rss', [TurboController::class, 'index']);
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// 404
Route::fallback([PageController::class, 'notFound']);
