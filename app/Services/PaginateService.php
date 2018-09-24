<?php

namespace App\Services;


class PaginateService
{
    public function paginationData($perPage, $currentPage, $currentUrl, $count)
    {
        $lastNumberPage = max((int) ceil($count / $perPage), 1);

        return [
            'perPage' => $perPage,
            'currentPage' => $currentPage,
            'currentUrl' => $currentUrl,
            'lastNumberPage' => $lastNumberPage,
            'previousNumberPage' => $currentPage - 1,
            'nextNumberPage' => $currentPage + 1,
            'hasPages' => $currentPage != 1 || $currentPage < $lastNumberPage,
            'hasMorePages' => $currentPage < $lastNumberPage,
        ];
    }
}