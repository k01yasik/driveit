<?php

namespace App\Services;

use App\Entities\Post as PostEntity;
use App\Repositories\CachedPostRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    private CachedPostRepository $postRepository;

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

    public function countPostComments(array $comments): int
    {
        $count = 0;

        foreach ($comments as $c) {
            if ($c->is_verified === 1) {
                $count += $count + 1;
            }
        }
    }

    public function getPaginatedPostsByCategory(array $category, bool $isStart, int $id = null): LengthAwarePaginator
    {
        $posts = $this->postRepository->getPaginatedPostsByCategory($category);

        if ($isStart) {
            return new LengthAwarePaginator($posts, count($posts), 10);
        }

        return new LengthAwarePaginator($posts, count($posts), 10, $id, [
            'path' => null,
            'query' => null,
            'fragment' => null,
            'pageName' => 'page'
        ]);
    }

    public function store(PostEntity $postEntity, int $userId, array $postCategoriesId): void
    {
        $this->postRepository->store($postEntity, $userId, $postCategoriesId);
    }

    public function update(PostEntity $postEntity, int $userId, int $postId, array $postCategoriesId): void
    {
        $this->postRepository->update($postEntity, $userId, $postId, $postCategoriesId);
    }

    public function updateHtml(PostEntity $postEntity, int $postId): void
    {
        $this->postRepository->updateHtml($postEntity, $postId);
    }

    public function getPostByIdWithUserData(int $postId): array
    {
        return $this->postRepository->getPostByIdWithUserData($postId);
    }

    public function getById(int $postId): array
    {
        return $this->postRepository->getById($postId);
    }

    public function changePublishStatus(PostEntity $postEntity): void
    {
        $this->postRepository->updateStatus($postEntity);
    }

    public function getPostByIdWithCategories(int $postId)
    {
        return $this->postRepository->getPostByIdWithCategories($postId);
    }

    public function createPost(string $slug,
                               string $title,
                               string $description,
                               string $name,
                               string $caption,
                               string $body,
                               string $imagePath): PostEntity
    {
        return PostEntity::create(null, $slug, $title, $description, $name, $caption, $body, $imagePath);
    }

    public function restorePost(int $id,
                                string $slug,
                                string $title,
                                string $description,
                                string $name,
                                string $caption,
                                string $body,
                                string $imagePath,
                                bool $isPublished,
                                int $views,
                                string $datePablished): PostEntity
    {
        return PostEntity::restoreFromDb($id, $slug, $title, $description, $name, $caption, $body, $imagePath, $isPublished, $views, $datePablished);
    }

    public function getPaginatedPostsOrderedById(bool $isStart, int $id = null): LengthAwarePaginator
    {
        $posts =  $this->postRepository->getPaginatedPostsOrderedById($isStart);

        if ($isStart) {
            return new LengthAwarePaginator($posts, count($posts), 10);
        }

        return new LengthAwarePaginator($posts, count($posts), 10, $id, [
            'path' => null,
            'query' => null,
            'fragment' => null,
            'pageName' => 'page'
        ]);
    }

    public function getAllPublishedPosts(): LengthAwarePaginator
    {
        $posts = $this->postRepository->getAllPublishedPosts();

        foreach ($posts as $post) {
            $post->rating_count = $this->countPostRating($post->rating->toArray());
            $post->comments_count = $this->countPostComments($post->comments->toArray());;
        }

        return new LengthAwarePaginator($posts, count($posts), 10);
    }

    public function getPaginatedPostsWithoutCache(int $id): LengthAwarePaginator
    {
        $posts = $this->postRepository->getPaginatedPostsWithoutCache();

        return new LengthAwarePaginator($posts, count($posts), 10, $id, [
            'path' => null,
            'query' => null,
            'fragment' => null,
            'pageName' => 'page'
        ]);
    }

    public function search(string $query): LengthAwarePaginator
    {
        $posts = $this->postRepository->search($query);

        return new LengthAwarePaginator($posts, count($posts), 10);
    }

    public function getAllPosts(): array
    {
        return $this->postRepository->getAllPublishedPosts();
    }

    public function getPostsForShow(string $slug): array
    {
        return $this->postRepository->getPostsForShow($slug);
    }

    public function getSuggests(array $suggestIds): array
    {
        return $this->postRepository->getSuggests($suggestIds);
    }

    public function incrementViews(int $postId): void
    {
        $this->postRepository->incrementViews($postId);
    }

    public function getPostsForSitemap(): array
    {
        return $this->postRepository->getPostsForSitemap();
    }
}