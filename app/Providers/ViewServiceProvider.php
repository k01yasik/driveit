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
        View::composer('components.profile', 'App\Http\View\Composers\ProfileComposer');
    }
}
