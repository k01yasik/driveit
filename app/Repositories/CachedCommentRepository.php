<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

final class CachedCommentRepository implements CommentRepositoryInterface
{
    private const CACHE_TTL = 3600; // 1 hour
    
    public function __construct(
        private CommentRepositoryInterface $commentRepository
    ) {}

    public function update(array $comment): void
    {
        $this->clearCommentCache($comment['id']);
        $this->commentRepository->update($comment);
    }

    public function save(array $comment): array
    {
        $result = $this->commentRepository->save($comment);
        $this->clearCommentCache($result['id']);
        return $result;
    }

    public function getCommentsByPost(int $id): array
    {
        return Cache::remember(
            "comments_for_post_{$id}", 
            self::CACHE_TTL,
            fn() => $this->commentRepository->getCommentsByPost($id)
        );
    }

    public function getById(int $id): array
    {
        return Cache::remember(
            "comment_{$id}",
            self::CACHE_TTL,
            fn() => $this->commentRepository->getById($id)
        );
    }

    public function create(CommentDTO $dto): array {
        return $this->commentRepository->create($dto);
    }

    public function getCommentsVerifiedCount(): int
    {
        return Cache::remember(
            'comments_verified_count',
            self::CACHE_TTL,
            fn() => $this->commentRepository->getCommentsVerifiedCount()
        );
    }

    public function getCommentsNotVerifiedCount(): int
    {
        return Cache::remember(
            'comments_not_verified_count',
            self::CACHE_TTL,
            fn() => $this->commentRepository->getCommentsNotVerifiedCount()
        );
    }

    public function getPaginatedComments(bool $isStart, ?int $id = null): LengthAwarePaginator
    {
        return $this->commentRepository->getPaginatedComments($isStart, $id);
    }

    public function getUnpublishedComments(): array
    {
        return Cache::remember(
            'unpublished_comments',
            self::CACHE_TTL,
            fn() => $this->commentRepository->getUnpublishedComments()
        );
    }

    private function clearCommentCache(int $commentId): void
    {
        Cache::forget("comment_{$commentId}");
        Cache::forget('comments_verified_count');
        Cache::forget('comments_not_verified_count');
        Cache::forget('unpublished_comments');
    }
}
