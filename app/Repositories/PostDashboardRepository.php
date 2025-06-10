<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\PostDashboardRepositoryInterface;
use Illuminate\Database\QueryException;

class PostDashboardRepository implements PostDashboardRepositoryInterface
{
    public function getPostDashboard(): array
    {
        try {
            return DB::table('posts')
                ->select([
                    DB::raw('YEAR(date_published) as year'),
                    DB::raw('MONTH(date_published) as month'),
                    DB::raw('COUNT(1) as count')
                ])
                ->where('is_published', true)
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get()
                ->toArray();
        } catch (QueryException $e) {
            throw new \RuntimeException('Database error while fetching post dashboard data', 0, $e);
        }
    }
}
