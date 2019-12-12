<?php

namespace App\Repositories\Interfaces;
use App\User;
use App\Profile;

interface ProfileRepositoryInterface
{
    public function store(User $user, string $url): Profile;
}