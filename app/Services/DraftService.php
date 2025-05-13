<?php

namespace App\Services;

use App\DTO\DraftDTO;
use App\Repositories\Interfaces\DraftRepositoryInterface;
use App\Exceptions\DraftSaveException;

class DraftService
{
    public function __construct(
        private DraftRepositoryInterface $draftRepository
    ) {
    }

    /**
     * Get all drafts for a user
     *
     * @param int $userId
     * @return array
     */
    public function getUserDrafts(int $userId): array
    {
        return $this->draftRepository->getUserDrafts($userId);
    }

    /**
     * Save a draft
     *
     * @param DraftDTO $draft
     * @param int $userId
     * @return bool
     * @throws DraftSaveException
     */
    public function save(DraftDTO $draft, int $userId): bool
    {
        try {
            $this->draftRepository->save($draft, $userId);
            return true;
        } catch (\Exception $e) {
            throw new DraftSaveException('Failed to save draft', 0, $e);
        }
    }
}
