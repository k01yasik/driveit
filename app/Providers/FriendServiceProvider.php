<?php

namespace App\Providers;

use App\Repositories\FriendRepository;
use App\Repositories\Interfaces\FriendRepositoryInterface;
use App\Services\FriendService;
use App\Services\Interfaces\FriendServiceInterface;
use Illuminate\Support\ServiceProvider;

class FriendServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(FriendServiceInterface::class, FriendService::class);
        $this->app->bind(FriendRepositoryInterface::class, FriendRepository::class);
    }
}
