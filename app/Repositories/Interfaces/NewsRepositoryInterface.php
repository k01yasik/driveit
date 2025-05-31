<?php

namespace App\Repositories\Interfaces;

use App\Dto\NewsCollection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface NewsRepositoryInterface
{
    public function getLastNews(int $limit = 10): NewsCollection;
    public function getPaginatedNews(int $perPage = 15): LengthAwarePaginator;
    public function findById(int $id): ?array;
    public function create(array $data): array;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function togglePublish(int $id): bool;
}
