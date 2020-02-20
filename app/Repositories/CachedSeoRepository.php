<?php


namespace App\Repositories;


use App\Repositories\Interfaces\SeoRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

final class CachedSeoRepository implements SeoRepositoryInterface
{
    protected $seo;

    public function __construct(SeoRepositoryInterface $seo)
    {
        $this->seo = $seo;
    }

    public function getSeoData(string $name): Model
    {
        return Cache::rememberForever($name, function () use ($name) {
            return $this->seo->getSeoData($name);
        });
    }

    public function getAllData(): Collection
    {
        return $this->seo->getAllData();
    }

    public function getSeoById(int $id): Model
    {
        return $this->seo->getSeoById($id);
    }

    public function store(array $data): bool
    {
        return $this->seo->store($data);
    }
}