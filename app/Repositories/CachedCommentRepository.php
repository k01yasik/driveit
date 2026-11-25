<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\CommentDTO;
use App\DTO\CommentUpdateDTO;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\CachedRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

final class CachedCommentRepository implements CommentRepositoryInterface, CachedRepositoryInterface
{
    private const CACHE_TTL = 3600; // 1 hour
    private const CACHE_PREFIX = 'comment_';

    public function __construct(
        private CommentRepositoryInterface $commentRepository
    ) {}

    public function getById(int $id): array
    {
        return Cache::remember(
            self::CACHE_PREFIX . $id,
            self::CACHE_TTL,
            fn() => $this->commentRepository->getById($id)
        );
    }

    public function update(CommentUpdateDTO $commentData): void
    {
        $oldPostIds = $this->getPostIdsForComments([$commentData->id]);
        $this->commentRepository->update($commentData);

        $this->clearCache($commentData->id);
        $this->clearPostCaches(array_unique([...$oldPostIds, $commentData->postId]));
    }

    public function updateMessage(int $id, string $message): void
    {
        $postId = $this->getById($id)['post_id'];
        $this->commentRepository->updateMessage($id, $message);
        $this->clearCache($id);
        Cache::forget("comments_for_post_{$postId}");
    }

    public function toggleVerification(int $id): void
    {
        $postId = $this->getById($id)['post_id'];
        $this->commentRepository->toggleVerification($id);
        $this->clearCache($id);
        Cache::forget("comments_for_post_{$postId}");
    }

    public function create(CommentDTO $commentData): array
    {
        $result = $this->commentRepository->create($commentData);
        $this->clearCache($result['id']);
        Cache::forget("comments_for_post_{$commentData->postId}");
        return $result;
    }

    public function getVerifiedCount(): int
    {
        return Cache::remember(
            'comments_verified_count',
            self::CACHE_TTL,
            fn() => $this->commentRepository->getVerifiedCount()
        );
    }

    public function getUnverifiedCount(): int
    {
        return Cache::remember(
            'comments_unverified_count',
            self::CACHE_TTL,
            fn() => $this->commentRepository->getUnverifiedCount()
        );
    }

    public function getByPostId(int $postId): array
    {
        return Cache::remember(
            "comments_for_post_{$postId}",
            self::CACHE_TTL,
            fn() => $this->commentRepository->getByPostId($postId)
        );
    }

    public function getPaginated(?int $page = null): LengthAwarePaginator
    {
        return $this->commentRepository->getPaginated($page);
    }

    public function getUnverified(): array
    {
        return Cache::remember(
            'unverified_comments',
            self::CACHE_TTL,
            fn() => $this->commentRepository->getUnverified()
        );
    }

    public function exists(int $id): bool
    {
        return Cache::remember(
            "comment_exists_{$id}",
            self::CACHE_TTL,
            fn() => $this->commentRepository->exists($id)
        );
    }

    public function isParentValid(int $parentId, int $postId): bool
    {
        return $this->commentRepository->isParentValid($parentId, $postId);
    }

    public function clearCache(int $commentId): void
    {
        $this->clearCommentCache($commentId);
        $this->clearAllCache();
    }

    private function clearCommentCache(int $commentId): void
    {
        Cache::forget(self::CACHE_PREFIX . $commentId);
        Cache::forget("comment_exists_{$commentId}");
    }

    public function clearAllCache(): void
    {
        Cache::forget('comments_verified_count');
        Cache::forget('comments_unverified_count');
        Cache::forget('unverified_comments');
    }

    public function getPostIdsForComments(array $ids): array
    {
        return $this->commentRepository->getPostIdsForComments($ids);
    }

    public function bulkVerify(array $ids): int
    {
        $postIds = $this->getPostIdsForComments($ids);
        $updated = $this->commentRepository->bulkVerify($ids);

        foreach ($ids as $id) {
            $this->clearCommentCache($id);
        }
        $this->clearAllCache();
        $this->clearPostCaches($postIds);

        return $updated;
    }

    private function clearPostCaches(array $postIds): void
    {
        foreach ($postIds as $postId) {
            Cache::forget("comments_for_post_{$postId}");
        }
    }
}
