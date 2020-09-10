<?php

namespace App\Repositories\Interfaces;
use App\User;
use App\Profile;

interface ProfileRepositoryInterface
{
    public function add(int $userId, string $avatarUrl): void;
}