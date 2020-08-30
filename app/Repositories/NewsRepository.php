<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 28.10.2019
 * Time: 14:42
 */

namespace App\Repositories;


use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\News;
use Illuminate\Database\Eloquent\Collection;

class NewsRepository implements NewsRepositoryInterface
{

    /**
     * @return Collection|\Illuminate\Support\Collection|static[]
     */
    public function getLastNews()
    {
        return News::published()->orderBy('date_published', 'desc')->take(10)->get();
    }
}