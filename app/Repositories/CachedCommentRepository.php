<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\CommentUpdateDTO;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

final class CachedCommentRepository implements CommentRepositoryInterface
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

    public function update(CommentUpdateDTO $comment): void
    {
        $this->clearCache($comment->id);
        $this->commentRepository->update($comment);
    }

    public function create(array $comment): array
    {
        $result = $this->commentRepository->create($comment);
        $this->clearCache($result['id']);
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
        // Пагинацию обычно не кэшируют полностью
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
        $cacheKey = "parent_valid_{$parentId}_{$postId}";
        
        return Cache::remember(
            $cacheKey,
            self::CACHE_TTL,
            fn() => $this->commentRepository->isParentValid($parentId, $postId)
        );
    }

    private function clearCache(int $commentId): void
    {
        $keys = [
            self::CACHE_PREFIX . $commentId,
            'comments_verified_count',
            'comments_unverified_count',
            'unverified_comments',
            "comment_exists_{$commentId}"
        ];
        
        foreach ($keys as $key) {
            Cache::forget($key);
        }
        
        // Также очищаем кэш для родительских комментариев
        Cache::forget("parent_valid_{$commentId}_*");
    }
}
