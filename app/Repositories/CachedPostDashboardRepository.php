<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 14.11.2019
 * Time: 0:08
 */

namespace App\Repositories;


use Illuminate\Support\Collection as Collection;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Interfaces\PostDashboardRepositoryInterface;

final class CachedPostDashboardRepository implements PostDashboardRepositoryInterface
{

    private $cachedPostDashboard;

    public function __construct(PostDashboardRepositoryInterface $cachedPostDashboard)
    {
        $this->cachedPostDashboard = $cachedPostDashboard;
    }

    public function getPostDashboard(): Collection
    {
        return Cache::rememberForever('posts_count_cart', function () {
            return $this->cachedPostDashboard->getPostDashboard();
        });
    }
}