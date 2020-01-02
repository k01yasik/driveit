<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;


interface MessageRepositoryInterface
{
    public function store(int $userId, int $friendId, string $message): Model;

    public function getMessages(int $current_id, int $friend_id): Collection;
}