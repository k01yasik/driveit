<?php

namespace App\Services;

use App\Repositories\Interfaces\PostDashboardRepositoryInterface;
use Illuminate\Support\Collection;

class PostDashboardService
{
    public function __construct(
        private PostDashboardRepositoryInterface $cachedPostDashboardRepository
    ) {
    }

    public function getPostDashboard(): Collection
    {
        try {
            return collect($this->cachedPostDashboardRepository->getPostDashboard());
        } catch (\Exception $e) {
            // Log the error and consider a fallback strategy
            throw new \RuntimeException('Failed to retrieve post dashboard data', 0, $e);
        }
    }
}
