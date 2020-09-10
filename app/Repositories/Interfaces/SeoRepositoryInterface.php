<?php

namespace App\Repositories\Interfaces;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Collection;

interface SeoRepositoryInterface
{
    public function getSeoData(string $name): array;

    public function getAllData(): array;

    public function getSeoById(int $id): array;

    public function store(string $route, string $title, string $description): bool;

    public function update(int $seoId, string $title, string $description): bool;

    public function delete(int $id): void;
}