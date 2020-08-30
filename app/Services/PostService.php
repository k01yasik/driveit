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

    /**
     * @param Model $post
     */
    public function countPostRating(Model $post): void
    {
        $post->rating_count = 0;

        foreach ($post->rating as $r) {
            if ($r->rating === 1) {
                $post->rating_count = $post->rating_count + 1;
            }
        }
    }

    /**
     * @param Model $post
     */
    public function countPostComments(Model $post): void
    {
        $post->comments_count = 0;

        foreach ($post->comments as $c) {
            if ($c->is_verified === 1) {
                $post->comments_count = $post->comments_count + 1;
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