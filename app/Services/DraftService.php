<?php

namespace App\Services;

use App\Draft;
use App\Repositories\Interfaces\DraftRepositoryInterface;

class DraftService
{
    protected $draftRepository;

    public function __construct(DraftRepositoryInterface $draftRepository)
    {
        $this->draftRepository = $draftRepository;
    }
}