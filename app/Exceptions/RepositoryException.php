<?php

namespace App\Exceptions;

class RepositoryException extends \Exception
{
    public static function notFound(int $userId, int $imageId, \Throwable $previous = null): self
    {
        return new self("Favorite not found for user $userId and image $imageId", 0, $previous);
    }

    public static function createError(string $context, \Throwable $previous = null): self
    {
        return new self("Failed to create favorite for $context", 0, $previous);
    }

    public static function deleteError(string $context, \Throwable $previous = null): self
    {
        return new self("Failed to delete favorite for $context", 0, $previous);
    }
}
