<?php

namespace App\Repositories\Interfaces;

use App\Profile;
use App\User;

interface ProfileRepositoryInterface
{
    public function initialize(User $user, string $avatarUrl): Profile;

    public function update(int $userId, array $attributes): void;
}
