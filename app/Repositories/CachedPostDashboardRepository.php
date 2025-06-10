<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use App\Repositories\Interfaces\PostDashboardRepositoryInterface;
use Illuminate\Support\Collection;

final class CachedPostDashboardRepository implements PostDashboardRepositoryInterface
{
    private const CACHE_KEY = 'posts_dashboard_stats';
    private const CACHE_TTL = 86400; // 24 hours in seconds

    public function __construct(
        private PostDashboardRepositoryInterface $postDashboardRepository
    ) {
    }

    public function getPostDashboard(): array
    {
        return Cache::remember(
            self::CACHE_KEY,
            self::CACHE_TTL,
            fn () => $this->postDashboardRepository->getPostDashboard()
        );
    }
    
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
