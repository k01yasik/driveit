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

class NewsRepository implements NewsRepositoryInterface
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function getLastNews()
    {
        return News::published()->orderBy('date_published', 'desc')->take(10)->get();
    }
}