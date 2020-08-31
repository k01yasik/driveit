<?php

namespace App\Services;

use App\Repositories\CachedPostRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Database\Eloquent\Model;


class PostService
{
    private $postRepository;

    public function __construct(CachedPostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function countPostRating(array $rating): int
    {
        $count = 0;

        foreach ($rating as $r) {
            if ($r->rating === 1) {
                $count += $count + 1;
            }
        }

        return $count;
    }

    /**
     * @param array $comments
     * @return int
     */
    public function countPostComments(array $comments): int
    {
        $count = 0;

        foreach ($comments as $c) {
            if ($c->is_verified === 1) {
                $count += $count + 1;
            }
        }
    }

    public function getPaginatedPostsByCategory(array $category, bool $isStart, int $id = null): Paginator
    {
        $posts = $this->postRepository->getPaginatedPostsByCategory($category);

        if ($isStart) {
            return $posts->paginate(10);
        }

        return $posts->paginate(10, ['*'], 'page', $id);
    }
}