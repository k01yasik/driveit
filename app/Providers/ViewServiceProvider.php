<?php


namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot():void
    {
        View::composer(
            [
                'components.profile',
                'user.friends',
                'user.public',
                'user.messages',
                'user.albums.edit',
                'user.albums.show',
                'user.albums.create',
                'user.settings',
                'user.requests',
                'user.friendmessages'
            ],
            'App\Http\View\Composers\ProfileComposer'
        );

        View::composer(
            [
                'category.show',
                'category.paginate',
            ],
            'App\Http\View\Composers\CategoryComposer'
        );
    }
}
