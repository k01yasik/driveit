<?php

namespace App\Providers;

use App\Repositories\CachedPostDashboardRepository;
use App\Repositories\CachedPostRepository;
use App\Repositories\CachedUserRepository;
use App\Repositories\CachedCommentRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\FriendRepository;
use App\Repositories\ImageRepository;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\FavoriteRepositoryInterface;
use App\Repositories\Interfaces\FriendRepositoryInterface;
use App\Repositories\Interfaces\ImageRepositoryInterface;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\Repositories\Interfaces\PostDashboardRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\Interfaces\RatingRepositoryInterface;
use App\Repositories\Interfaces\RipRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\AlbumRepositoryInterface;
use App\Repositories\Interfaces\MessageRepositoryInterface;
use App\Repositories\MessageRepository;
use App\Repositories\NewsRepository;
use App\Repositories\PostDashboardRepository;
use App\Repositories\PostRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\RatingRepository;
use App\Repositories\RipRepository;
use App\Repositories\UserRepository;
use App\Repositories\FavoriteRepository;
use App\Repositories\AlbumRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            NewsRepositoryInterface::class,
            NewsRepository::class
        );

        $this->app->when(CachedPostRepository::class)
            ->needs(PostRepositoryInterface::class)
            ->give(PostRepository::class);

        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->when(CachedUserRepository::class)
            ->needs(UserRepositoryInterface::class)
            ->give(UserRepository::class);

        $this->app->when(CachedCommentRepository::class)
            ->needs(CommentRepositoryInterface::class)
            ->give(CommentRepository::class);

        $this->app->when(CachedPostDashboardRepository::class)
            ->needs(PostDashboardRepositoryInterface::class)
            ->give(PostDashboardRepository::class);

        $this->app->bind(
            FavoriteRepositoryInterface::class,
            FavoriteRepository::class
        );

        $this->app->bind(
            ProfileRepositoryInterface::class,
            ProfileRepository::class
        );

        $this->app->bind(
            AlbumRepositoryInterface::class,
            AlbumRepository::class
        );

        $this->app->bind(
            ImageRepositoryInterface::class,
            ImageRepository::class
        );

        $this->app->bind(
            MessageRepositoryInterface::class,
            MessageRepository::class
        );

        $this->app->bind(
            FriendRepositoryInterface::class,
            FriendRepository::class
        );

        $this->app->bind(
            RatingRepositoryInterface::class,
            RatingRepository::class
        );

        $this->app->bind(
            RipRepositoryInterface::class,
            RipRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
