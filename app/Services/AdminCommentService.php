<?php

namespace App\Services;


use App\Repositories\CachedCommentRepository;

class AdminCommentService
{
    protected $commentRepository;

    public function __construct(CachedCommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function publish($id): void
    {
        $this->commentRepository->publish($id);
    }
}