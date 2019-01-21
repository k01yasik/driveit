<?php

namespace App\Providers;

use App\Comment;
use App\Observers\CommentObserver;
use App\Observers\PostObserver;
use App\Observers\ProfileObserver;
use App\Observers\RatingObserver;
use App\Observers\RipObserver;
use App\Observers\UserObserver;
use App\Post;
use App\Profile;
use App\Rating;
use App\Rip;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Rating::observe(RatingObserver::class);
        Post::observe(PostObserver::class);
        Comment::observe(CommentObserver::class);
        Rip::observe(RipObserver::class);
        User::observe(UserObserver::class);
        Profile::observe(ProfileObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
