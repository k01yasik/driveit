<?php

namespace App\Repositories\Interfaces;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Collection;

interface SeoRepositoryInterface
{
    public function getSeoData(string $name): Model;

    public function getAllData(): Collection;

    public function getSeoById(int $id): Model;

    public function store(array $data): bool;
}