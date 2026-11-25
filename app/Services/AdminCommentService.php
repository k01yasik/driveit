<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Interfaces\CommentRepositoryInterface;

class AdminCommentService
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository
    ) {}

    public function publish(int $id): void
    {
        $this->commentRepository->toggleVerification($id);
    }
}
