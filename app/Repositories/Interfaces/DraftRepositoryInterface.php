<?php

namespace App\Repositories\Interfaces;

use App\Dto\Draft;
use App\User;

interface DraftRepositoryInterface
{
    public function getUserDrafts(int $id): array;

    public function save(Draft $draft, User $user): bool;
}