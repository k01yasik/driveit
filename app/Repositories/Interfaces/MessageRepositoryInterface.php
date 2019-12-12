<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface MessageRepositoryInterface
{
    public function store(int $userId, int $friendId, string $message): Model;
}