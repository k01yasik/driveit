<?php

namespace App\Repositories;

use App\Repositories\Interfaces\SeoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Seo;
use Illuminate\Support\Facades\Log;

class SeoRepository implements SeoRepositoryInterface
{
    public function getSeoData(string $name): array
    {
        $seo = Seo::where('route_name', $name)->firstOrFail();

        if ($seo instanceof Model) {
            return $seo->toArray();
        }

        return [];
    }

    public function getAllData(): array
    {
        return Seo::all()->toArray();
    }

    public function getSeoById(int $id): array
    {
        return Seo::find($id)->toArray();
    }

    public function store(string $route, string $title, string $description): bool
    {
        $seo = new Seo;
        $seo->route_name = $route;
        $seo->title = $title;
        $seo->description = $description;
        return $seo->save();
    }

    public function update(int $seoId, string $title, string $description): bool
    {
        $seo = Seo::findOrFail($seoId);

        $seo->title = $title;
        $seo->description = $description;

        return $seo->save();
    }

    public function delete(int $id): void
    {
        $seo = Seo::findOrFail($id);

        if ($seo instanceof Model) {
            try {
                $seo->delete();
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }
}