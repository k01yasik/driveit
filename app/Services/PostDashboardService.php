<?php

namespace App\Services;


use App\Repositories\CachedPostDashboardRepository;

class PostDashboardService
{
    protected CachedPostDashboardRepository $cachedPostDashboardRepository;

    public function __construct(CachedPostDashboardRepository $cachedPostDashboardRepository)
    {
        $this->cachedPostDashboardRepository = $cachedPostDashboardRepository;
    }

    public function getPostDashboard()
    {
        return $this->cachedPostDashboardRepository->getPostDashboard();
    }
}