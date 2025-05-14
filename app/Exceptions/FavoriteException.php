<?php

namespace App\Exceptions;

class FavoriteException extends \Exception
{
    public static function alreadyExists(int $userId, int $imageId): self
    {
        return new self("User $userId already has favorite for image $imageId");
    }

    public static function notFound(int $userId, int $imageId): self
    {
        return new self("Favorite not found for user $userId and image $imageId");
    }
}
