<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection as Collection;

interface PostDashboardRepositoryInterface
{
    public function getPostDashboard(): Collection;
}