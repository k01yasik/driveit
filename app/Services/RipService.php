<?php

namespace App\Services;


use App\Repositories\Interfaces\RipRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use App\Rip;

class RipService
{
    protected $ripRepository;

    public function __construct(RipRepositoryInterface $ripRepository)
    {
        $this->ripRepository = $ripRepository;
    }

    public function store(int $id): void {
        $this->ripRepository->store($id);
    }

    public function delete(int $id): Model {
        return $this->ripRepository->delete($id);
    }
}