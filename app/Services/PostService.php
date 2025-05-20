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
            if ($r['rating'] == 1) {
                $count += 1;
            }
        }

        return $count;
    }

    public function countPostComments(array $comments): int
    {
        $count = 0;

        foreach ($comments as $c) {
            if ($c['is_verified'] === 1) {
                $count += 1;
            }
        }

        return $count;
    }

    public function getPaginatedPostsByCategoryId(int $categoryId, int $id): LengthAwarePaginator
    {
        $numberPosts = config('pagination.postsPerPage');

        $posts = $this->postRepository->getPaginatedPostsByCategoryId($categoryId, $id, $numberPosts);

        $posts = $this->calculatePostStats($posts);

        $postsCount = $this->postRepository->getPostsCountByCategory($categoryId);

        return new LengthAwarePaginator($posts, $postsCount, $numberPosts, $id, [
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

    public function getPostBySlugWithUserData(string $slug): array
    {
        return $this->postRepository->getPostBySlugWithUserData($slug);
    }
    
    public function getById(int $postId): array
    {
        return $this->postRepository->getById($postId);
    }

    public function changePublishStatus(PostEntity $postEntity): void
    {
        $isPublished = $this->postRepository->getPostStatus($postEntity);

        if ($isPublished) {
            $this->postRepository->unpublishPost($postEntity);
        } else {
            $this->postRepository->publishPost($postEntity);
        }
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

    public function getPaginatedPostsOrderedById(int $id): LengthAwarePaginator
    {
        $posts =  $this->postRepository->getPaginatedPostsOrderedById($id, config('pagination.postsPerPage'));

        $postsCount = $this->postRepository->getPostsCount();

        return new LengthAwarePaginator($posts, $postsCount, config('pagination.postsPerPage'), $id, [
            'path' => null,
            'query' => null,
            'fragment' => null,
            'pageName' => 'page'
        ]);
    }

    public function getPostsForPage(int $pageId, int $numberPosts): array
    {
        return $this->postRepository->getPostsForPage($pageId, $numberPosts);
    }

    public function getPostsPaginator(array $posts, int $pageId, int $numberPosts): LengthAwarePaginator
    {
        $postsCount = $this->postRepository->getPostsCount();

        return new LengthAwarePaginator($posts, $postsCount, $numberPosts, $pageId, [
            'path' => null,
            'query' => null,
            'fragment' => null,
            'pageName' => 'page'
        ]);
    }

    public function search(string $query): array
    {
        $posts = $this->postRepository->search($query);

        $posts = $this->calculatePostStats($posts);

        return $posts;
    }

    public function getAllPosts(): array
    {
        return $this->postRepository->getAllPublishedPosts();
    }

    public function getPostsByMonth(): array
    {
        return $this->postRepository->getPostsByMonth();
    }

    public function getPostsForShow(string $slug): array
    {
        return $this->postRepository->getPostsForShow($slug);
    }

    public function getSuggestsWithStats(array $suggestIds): array {
        return $this->calculatePostStats($this->getSuggests($suggestIds));
    }

    public function incrementViews(int $postId): void
    {
        $this->postRepository->incrementViews($postId);
    }

    public function getPostsForSitemap(): array
    {
        return $this->postRepository->getPostsForSitemap();
    }

    public function getTopPosts(int $count): array
    {
        $posts = $this->postRepository->getTopPosts($count);

        $posts = $this->calculatePostStats($posts);

        return $posts;
    }

    public function calculatePostStats(array $posts): array
    {
        $postsTemp = [];

        foreach ($posts as $post) {
            $post['rating_count'] = $this->countPostRating($post['rating']);
            $post['comments_count'] = $this->countPostComments($post['comments']);
            $postsTemp[] = $post;
        }

        return $postsTemp;
    }

    public function getPagesCount(): int
    {
        $numberPosts = $this->postRepository->getPostsCount();

        return ceil($numberPosts / config('pagination.postsPerPage'));
    }

    public function getPostsSortedByViews(int $pageId, int $numberPosts)
    {
        return $this->postRepository->getPostsSortedByViews($pageId, $numberPosts);
    }

    public function getAllPostsWithStats(): array {
        $posts = $this->getAllPosts();
        return $this->calculatePostStats($posts);
    }

    public function calculateAndPaginate(array $posts, int $page): array {
        $posts = $this->calculatePostStats($posts);
        return $this->getPostsPaginator($posts, $page, config('pagination.postsPerPage'));
    }
}
