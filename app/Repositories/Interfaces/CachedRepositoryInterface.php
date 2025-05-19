<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface CachedRepositoryInterface
{
    /**
     * Clear cache for specific item
     */
    public function clearCache(int $id): void;
    
    /**
     * Clear all cache
     */
    public function clearAllCache(): void;
}
