<?php

namespace App\Repositories;


use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

final class CachedCommentRepository implements CommentRepositoryInterface
{
    private CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function update(array $comment): bool
    {
        return $this->commentRepository->update($comment);
    }

    public function save(array $comment): array
    {
        return $this->commentRepository->save($comment);
    }

    public function getCommentsByPost(int $id): array
    {
        return $this->commentRepository->getCommentsByPost($id);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getById(int $id): array
    {
        return Cache::rememberForever('comment_'.$id, function () use ($id) {
            return $this->commentRepository->getById($id);
        });
    }

    public function getCommentsVerifiedCount(): int
    {
        return Cache::rememberForever('comments_verified', function () {
            return $this->commentRepository->getCommentsVerifiedCount();
        });
    }

    public function getCommentsNotVerifiedCount(): int
    {
        return Cache::rememberForever('comments_not_verified', function () {
            return $this->commentRepository->getCommentsNotVerifiedCount();
        });
    }

    /**
     * @param bool $isStart
     * @param int|null $id
     * @return Paginator
     */
    public function getPaginatedComments(bool $isStart, int $id = null): Paginator
    {
        return $this->commentRepository->getPaginatedComments($isStart, $id);
    }

    public function getUnpublishedComments(): array
    {
        return $this->commentRepository->getUnpublishedComments();
    }
}