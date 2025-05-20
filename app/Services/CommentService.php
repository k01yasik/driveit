<?php

declare(strict_types=1);

namespace App\Services;

use App\Comment;
use App\Repositories\CachedCommentRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use App\DTO\CommentDTO;
use App\DTO\CommentStoreResultDTO;

class CommentService
{
    private CachedCommentRepository $commentRepository;

    public function __construct(CachedCommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * Get nested comments structure for a post
     */
    public function getNestedComments(int $postId): array
    {
        $comments = $this->commentRepository->getByPostId($postId);
        return $this->buildNestedStructure($comments);
    }

    /**
     * Build nested comments structure recursively
     */
    private function buildNestedStructure(array $comments, ?int $parentId = null, int $level = 0): array
    {
        $result = [];
        
        foreach ($comments as $comment) {
            if ($comment['parent_id'] === $parentId) {
                $comment['children'] = $this->buildNestedStructure(
                    $comments, 
                    $comment['id'], 
                    $level + 1
                );
                $result[] = $comment;
            }
        }

        return $result;
    }

    public function getUnpublishedComments(): array
    {
        return $this->commentRepository->getUnpublishedComments();
    }

    public function getCommentsVerifiedCount(): int
    {
        return $this->commentRepository->getCommentsVerifiedCount();
    }

    public function getCommentsNotVerifiedCount(): int
    {
        return $this->commentRepository->getCommentsNotVerifiedCount();
    }

    public function getPaginatedComments(bool $isStart, ?int $id = null): LengthAwarePaginator
    {
        return $this->commentRepository->getPaginatedComments($isStart, $id);
    }

    public function store(CommentDTO $commentData): CommentStoreResultDTO
    {
        $user = Auth::user();
        
        $comment = [
            'user_id' => $user->id,
            'post_id' => $commentData->postId,
            'message' => clean($commentData->message),
            'is_verified' => false,
            'level' => $commentData->level,
            'parent_id' => $commentData->parentId > 0 ? $commentData->parentId : null,
        ];

        $savedComment = $this->commentRepository->save($comment);

        return new CommentStoreResultDTO(
            level: $savedComment['level'],
            username: $user->username,
            avatar: $user->profile()->first()->avatar,
            url: route('user.profile', ['username' => $user->username]),
            createdAt: $savedComment['created_at'],
            message: __('Comment was sent for moderation.')
        );
    }
}
