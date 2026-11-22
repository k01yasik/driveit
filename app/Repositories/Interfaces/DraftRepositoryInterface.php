<?php

namespace App\Repositories\Interfaces;

use App\DTO\DraftDTO;

interface DraftRepositoryInterface
{
    /**
     * Get all drafts for a user
     *
     * @param int $userId
     * @return array
     */
    public function getUserDrafts(int $userId): array;

    /**
     * Save a draft
     *
     * @param DraftDTO $draft
     * @param int $userId
     * @return void
     */
    public function save(DraftDTO $draft, int $userId): void;
}
