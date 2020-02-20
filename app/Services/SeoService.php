<?php

namespace App\Services;

use App\Repositories\CachedSeoRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SeoService
{
    protected $seoRepository;

    public function __construct(CachedSeoRepository $seoRepository)
    {
        $this->seoRepository = $seoRepository;
    }

    public function getSeoData(Request $request)
    {
        $name = $request->route()->getName();

        $seoData = $this->seoRepository->getSeoData($name);

        return $seoData;
    }

    public function getAllData(): Collection
    {
        return $this->seoRepository->getAllData();
    }

    public function getSeoById(int $id): Model
    {
        return $this->seoRepository->getSeoById($id);
    }

    public function store(array $data): bool
    {
        return $this->seoRepository->store($data);
    }
}