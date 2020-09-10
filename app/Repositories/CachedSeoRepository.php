<?php


namespace App\Repositories;


use App\Repositories\Interfaces\SeoRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

final class CachedSeoRepository implements SeoRepositoryInterface
{
    protected SeoRepositoryInterface $seoRepository;

    public function __construct(SeoRepositoryInterface $seoRepository)
    {
        $this->seoRepository = $seoRepository;
    }

    public function getSeoData(string $name): array
    {
        return Cache::rememberForever($name, function () use ($name) {
            return $this->seoRepository->getSeoData($name);
        });
    }

    public function getAllData(): array
    {
        return $this->seoRepository->getAllData();
    }

    public function getSeoById(int $id): array
    {
        return $this->seoRepository->getSeoById($id);
    }

    public function store(string $route, string $title, string $description): bool
    {
        return $this->seoRepository->store($route, $title, $description);
    }

    public function update(int $seoId, string $title, string $description): bool
    {
        return $this->seoRepository->update($seoId, $title, $description);
    }

    public function delete(int $id): void
    {
        $this->seoRepository->delete($id);
    }
}