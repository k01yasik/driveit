<?php

namespace App\Services;

use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\Dto\NewsCollection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NewsService
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository
    ) {
    }

    public function getLastNews(int $limit = 10): NewsCollection
    {
        return $this->newsRepository->getLastNews($limit);
    }

    public function getPaginatedNews(int $perPage = 15): LengthAwarePaginator
    {
        return $this->newsRepository->getPaginatedNews($perPage);
    }
}
