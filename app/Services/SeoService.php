<?php

namespace App\Services;

use App\Repositories\CachedSeoRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SeoService
{
    protected CachedSeoRepository $seoRepository;

    public function __construct(CachedSeoRepository $seoRepository)
    {
        $this->seoRepository = $seoRepository;
    }

    public function getSeoData(Request $request)
    {
        $name = $this->getRouteName($request);

        return $this->seoRepository->getSeoData($name);
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

    public function getRouteName(Request $request): string
    {
        return $request->route()->getName();
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