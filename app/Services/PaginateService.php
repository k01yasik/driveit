<?php

namespace App\Services;

class PaginateService
{
    public function paginationData(int $perPage, int $currentPage, string $currentUrl, int $count): array
    {
        $this->validateInput($perPage, $currentPage, $count);
        
        $lastPage = $this->calculateLastPage($perPage, $count);
        
        return [
            'perPage' => $perPage,
            'currentPage' => $currentPage,
            'currentUrl' => $currentUrl,
            'lastNumberPage' => $lastPage,
            'previousNumberPage' => $currentPage > 1 ? $currentPage - 1 : 1,
            'nextNumberPage' => min($currentPage + 1, $lastPage),
            'hasPages' => $this->hasPages($currentPage, $lastPage),
            'hasMorePages' => $currentPage < $lastPage,
        ];
    }

    protected function calculateLastPage(int $perPage, int $count): int
    {
        return max((int) ceil($count / $perPage), 1);
    }

    protected function hasPages(int $currentPage, int $lastPage): bool
    {
        return $currentPage != 1 || $currentPage < $lastPage;
    }

    private function validateInput(int $perPage, int $currentPage, int $count): void
    {
        if ($perPage <= 0) {
            throw new \InvalidArgumentException('Per page must be positive integer');
        }

        if ($currentPage <= 0) {
            throw new \InvalidArgumentException('Current page must be positive integer');
        }

        if ($count < 0) {
            throw new \InvalidArgumentException('Count cannot be negative');
        }
    }
}
