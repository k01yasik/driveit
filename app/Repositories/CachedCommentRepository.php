<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 13.11.2019
 * Time: 21:13
 */

namespace App\Repositories;


use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

final class CachedCommentRepository implements CommentRepositoryInterface
{
    private $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param int $id
     */
    public function publish(int $id): void
    {
        $this->commentRepository->publish($id);
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

    public function store(array $data): array
    {
        return $this->commentRepository->store($data);
    }

    public function getUnpublishedComments(): Collection
    {
        return $this->commentRepository->getUnpublishedComments();
    }
}