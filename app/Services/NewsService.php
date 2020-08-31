<?php

namespace App\Services;


use App\Repositories\Interfaces\NewsRepositoryInterface;

class NewsService
{
    protected NewsRepositoryInterface $newsRepository;

    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function getLastNews(): array
    {
        return $this->newsRepository->getLastNews();
    }
}