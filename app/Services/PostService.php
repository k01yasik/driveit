<?php

namespace App\Services;

use App\Services\SortService\PostOrder;
use App\Entities\Post as PostEntity;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
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
            if (in_array($c['is_verified'], [true, 1, '1'], true)) {
                $count += 1;
            }
        }

        return $count;
    }

    public function getPaginatedPostsByCategoryId(int $categoryId, int $id): LengthAwarePaginator
    {
        $posts = $this->postRepository->getPaginatedPostsByCategoryId($categoryId, $id, config('pagination.postsPerPage'));

        return $posts->through(fn ($post) => $this->addPostStats($post->toArray()));
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
        $post = $this->postRepository->getPostBySlugWithUserData($slug);
        return $this->calculatePostStats($post);
    }
    
    public function getById(int $postId): array
    {
        return $this->postRepository->getById($postId);
    }

    public function publish(int $postId): void
    {
        $this->postRepository->setPublication($postId, true);
    }

    public function unpublish(int $postId): void
    {
        $this->postRepository->setPublication($postId, false);
    }

    public function archive(int $postId): void
    {
        $this->postRepository->setArchived($postId, true);
    }

    public function restore(int $postId): void
    {
        $this->postRepository->setArchived($postId, false);
    }

    public function getPostByIdWithCategories(int $postId): array
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
        $perPage = config('pagination.postsPerPage');

        return $this->paginate(
            $this->postRepository->getPaginatedPostsOrderedById($id, $perPage),
            $this->postRepository->getPostsCount(),
            $perPage,
            $id
        );
    }

    public function getPostsForPage(int $pageId, int $numberPosts): array
    {
        return $this->postRepository->getPostsForPage($pageId, $numberPosts);
    }

    public function getPostsPaginator(array $posts, int $pageId, int $numberPosts): LengthAwarePaginator
    {
        return $this->paginate($posts, $this->postRepository->getPublishedPostsCount(), $numberPosts, $pageId);
    }

    private function paginate(array $posts, int $total, int $perPage, int $page): LengthAwarePaginator
    {
        return new LengthAwarePaginator($posts, $total, $perPage, $page);
    }

    public function search(string $query): array
    {
        return $this->calculatePostStats($this->postRepository->search($query));
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

    public function getSuggestsWithStats(array $suggestIds): array
    {
        return $this->calculatePostStats($this->postRepository->getSuggests($suggestIds));
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
        return $this->calculatePostStats($this->postRepository->getTopPosts($count));
    }

    public function calculatePostStats(array $posts): array
    {
        if (array_key_exists('rating', $posts)) {
            return $this->addPostStats($posts);
        }

        return array_map($this->addPostStats(...), array_values($posts));
    }

    private function addPostStats(array $post): array
    {
        $post['rating_count'] = $this->countPostRating($post['rating']);
        $post['comments_count'] = $this->countPostComments($post['comments']);

        return $post;
    }

    public function getPagesCount(): int
    {
        $numberPosts = $this->postRepository->getPostsCount();

        return (int) ceil($numberPosts / config('pagination.postsPerPage'));
    }

    public function paginateRankedPosts(PostOrder $order, int $page): LengthAwarePaginator
    {
        $posts = $this->postRepository->paginateRankedPosts($order, $page, config('pagination.postsPerPage'));

        return $posts->through(fn ($post) => $this->addPostStats($post->toArray()));
    }

    public function calculateAndPaginate(array $posts, int $page): LengthAwarePaginator
    {
        $posts = $this->calculatePostStats($posts);
        return $this->getPostsPaginator($posts, $page, config('pagination.postsPerPage'));
    }
}
