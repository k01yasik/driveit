<?php

namespace App\Repositories;

use App\Repositories\Interfaces\SeoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Seo;

class SeoRepository implements SeoRepositoryInterface
{
    public function getSeoData(string $name): Model
    {
        return Seo::where('route_name', $name)->firstOrFail();
    }

    public function getAllData(): Collection
    {
        return Seo::all();
    }

    public function getSeoById(int $id): Model
    {
        return Seo::find($id);
    }

    public function store(array $data): bool
    {
        $seo = new Seo;
        $seo->route_name = $data['route'];
        $seo->title = $data['title'];
        $seo->description = $data['description'];
        $ok = $seo->save();

        return $ok;
    }
}