<?php

namespace App\Services;

use App\Repositories\Interfaces\DraftRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DraftService
{
    protected $draftRepository;

    public function __construct(DraftRepositoryInterface $draftRepository)
    {
        $this->draftRepository = $draftRepository;
    }

    public function getUserDrafts(): Collection
    {
        return $this->draftRepository->getUserDrafts();
    }

    public function store(Array $data): bool
    {
        return $this->draftRepository->store($data);
    }
}