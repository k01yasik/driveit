<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface RipRepositoryInterface
{
    public function store(int $id): void;

    public function delete(int $id): Model;
}