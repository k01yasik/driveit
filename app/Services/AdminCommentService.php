<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\CachedCommentRepository;

class AdminCommentService
{
    public function __construct(
        private CachedCommentRepository $commentRepository
    ) {}

    public function publish(int $id): void
    {
        $this->commentRepository->toggleVerification($id);
    }
}
