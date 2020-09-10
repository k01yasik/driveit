<?php

namespace App\Services;

use App\Dto\Draft;
use App\Repositories\Interfaces\DraftRepositoryInterface;
use App\User;

class DraftService
{
    protected DraftRepositoryInterface $draftRepository;

    public function __construct(DraftRepositoryInterface $draftRepository)
    {
        $this->draftRepository = $draftRepository;
    }

    public function getUserDrafts(int $id): array
    {
        return $this->draftRepository->getUserDrafts($id);
    }

    public function save(Draft $draft, int $userId): bool
    {
        $this->draftRepository->save($draft, $userId);
    }
}