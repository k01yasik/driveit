<?php

namespace App\Repositories;


use Illuminate\Support\Collection as Collection;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Interfaces\PostDashboardRepositoryInterface;

final class CachedPostDashboardRepository implements PostDashboardRepositoryInterface
{

    private PostDashboardRepositoryInterface $cachedPostDashboard;

    public function __construct(PostDashboardRepositoryInterface $cachedPostDashboard)
    {
        $this->cachedPostDashboard = $cachedPostDashboard;
    }

    public function getPostDashboard(): array
    {
        return Cache::rememberForever('posts_count_cart', function () {
            return $this->cachedPostDashboard->getPostDashboard();
        });
    }
}