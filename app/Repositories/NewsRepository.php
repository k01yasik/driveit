<?php

namespace App\Repositories;

use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\News;
use Illuminate\Database\Eloquent\Collection;

class NewsRepository implements NewsRepositoryInterface
{
    public function getLastNews(): array
    {
        return News::published()->orderBy('date_published', 'desc')->take(10)->get()->toArray();
    }
}