<?php

namespace App\Services;

use App\User;

class AirlockService
{
    public function createTokenForUser(int $id): void
    {
        $user = User::findOrFail($id);
        $user->createToken(config('app.name'));
    }
}