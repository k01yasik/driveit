<?php

namespace App\Repositories;

use Illuminate\Support\Collection as Collection;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\PostDashboardRepositoryInterface;

class PostDashboardRepository implements PostDashboardRepositoryInterface
{

    public function getPostDashboard(): Collection
    {
        return DB::table('posts')
            ->select(DB::raw('SQL_NO_CACHE YEAR(date_published) year, MONTH(date_published) month, COUNT(1) count'))
            ->where('is_published', true)
            ->groupBy(DB::raw('YEAR(date_published), MONTH(date_published)'))
            ->get();
    }
}