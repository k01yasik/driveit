<?php

namespace App\Repositories\Interfaces;

interface RipRepositoryInterface
{
    public function store(int $userId): void;

    public function delete(int $userId): void;

    public function getAll(): array;
}