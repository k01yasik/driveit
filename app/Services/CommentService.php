<?php

declare(strict_types=1);

namespace App\Services;

use App\Comment;
use App\Repositories\CachedCommentRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
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
        return $this->commentRepository->getUnverified();
    }

    public function getCommentsVerifiedCount(): int
    {
        return $this->commentRepository->getVerifiedCount();
    }

    public function getCommentsNotVerifiedCount(): int
    {
        return $this->commentRepository->getUnverifiedCount();
    }

    public function getPaginatedComments(bool $isStart, ?int $id = null): LengthAwarePaginator
    {
        return $this->commentRepository->getPaginated($isStart ? 1 : $id);
    }

    public function editMessage(Comment $comment, string $message): bool
    {
        $message = clean($message);

        if (blank(trim(html_entity_decode(strip_tags($message)), " \t\n\r\0\x0B\xc2\xa0"))) {
            throw ValidationException::withMessages(['message' => __('The message field is required.')]);
        }

        if ($message === $comment->message) {
            return false;
        }

        $this->commentRepository->updateMessage($comment->id, $message);

        return true;
    }

    public function store(CommentDTO $commentData): CommentStoreResultDTO
    {
        $user = Auth::user();
        
        $savedComment = $this->commentRepository->create(new CommentDTO(
            userId: $commentData->userId,
            postId: $commentData->postId,
            message: clean($commentData->message),
            level: $commentData->level,
            parentId: $commentData->parentId
        ));

        return new CommentStoreResultDTO(
            level: $savedComment['level'],
            username: $user->username,
            avatar: $savedComment['user']['profile']['avatar'] ?? '',
            url: route('user.profile', ['username' => $user->username]),
            createdAt: $savedComment['created_at'],
            message: __('Comment was sent for moderation.')
        );
    }
}
