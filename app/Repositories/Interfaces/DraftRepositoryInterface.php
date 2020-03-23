<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface DraftRepositoryInterface
{
    public function getUserDrafts(): Collection;

    public function store(Array $data): bool;
}