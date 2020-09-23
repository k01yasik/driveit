<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;

class PaginatorService
{
    /**
     * Calculate number of pages for pagination on view
     *
     * @param Paginator $paginator
     * @return array
     */
    public function calculatePages(Paginator $paginator): array
    {
        $previousNumberPage = $paginator->currentPage() - 1;
        $nextNumberPage = $paginator->currentPage() + 1;
        $lastNumberPage = $paginator->lastPage();

        return array($previousNumberPage, $nextNumberPage, $lastNumberPage);
    }
}