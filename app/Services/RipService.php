<?php

namespace App\Services;


use App\Repositories\Interfaces\RipRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use App\Rip;

class RipService
{
    protected RipRepositoryInterface $ripRepository;

    public function __construct(RipRepositoryInterface $ripRepository)
    {
        $this->ripRepository = $ripRepository;
    }

    public function store(int $userId): void
    {
        $this->ripRepository->store($userId);
    }

    public function delete(int $userId): void
    {
        $this->ripRepository->delete($userId);
    }
}