<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginatorService
{
    /**
     * Calculate pagination metadata
     *
     * @param LengthAwarePaginator $paginator
     * @return array<string, int>
     */
    public function calculatePages(LengthAwarePaginator $paginator): array
    {
        return [
            'previous' => max($paginator->currentPage() - 1, 1),
            'next' => min($paginator->currentPage() + 1, $paginator->lastPage()),
            'last' => $paginator->lastPage(),
            'current' => $paginator->currentPage(),
        ];
    }
}
