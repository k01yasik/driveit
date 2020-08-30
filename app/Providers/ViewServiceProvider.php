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
                'user.albums.index',
                'user.albums.edit',
                'user.albums.show',
                'user.settings',
                'user.friendmessages'
            ],
            'App\Http\View\Composers\ProfileComposer'
        );

        View::composer(
            [
                'category.show',
            ],
            'App\Http\View\Composers\CategoryComposer'
        );
    }
}
