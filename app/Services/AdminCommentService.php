<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Dto\CommentUpdateDTO;

class AdminCommentService
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository
    ) {}

    public function publish(int $id): void
    {
        $comment = $this->commentRepository->getById($id);
        $updatedComment = $this->toggleVerificationStatus($comment);
        
        $this->commentRepository->update(
            new CommentUpdateDTO(
                id: $id,
                userId: $comment['user_id'],
                postId: $comment['post_id'],
                message: $comment['message'],
                level: $comment['level'],
                parentId: $comment['parent_id'],
                isVerified: !$comment['is_verified']
            )
        );
    }

    private function toggleVerificationStatus(array $comment): array
    {
        $comment['is_verified'] = !$comment['is_verified'];
        return $comment;
    }
}
