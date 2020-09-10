<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 24.11.2019
 * Time: 21:28
 */

namespace App\Repositories;

use App\Post;
use App\Entities\Post as PostEntity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

final class CachedPostRepository implements PostRepositoryInterface
{
    protected PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function store(PostEntity $post, int $userId, array $postCategoriesId): void
    {
        $this->postRepository->store($post, $userId, $postCategoriesId);
    }

    public function update(PostEntity $post, int $userId, int $postId, array $postCategoriesId): void
    {
        $this->postRepository->update($post, $userId, $postId, $postCategoriesId);
    }

    public function updateHtml(PostEntity $postEntity, int $postId): void
    {
        $this->postRepository->updateHtml($postEntity, $postId);
    }

    public function getPostByIdWithUserData(int $postId): array
    {
        return $this->postRepository->getPostByIdWithUserData($postId);
    }

    public function getPostByIdWithCategories(int $postId): array
    {
        return $this->postRepository->getPostByIdWithCategories($postId);
    }

    public function getPostBySlugWithUserData(string $slug): array
    {
        return $this->postRepository->getPostBySlugWithUserData($slug);
    }

    public function getById(int $postId): array
    {
        return $this->postRepository->getById($postId);
    }

    public function updateStatus(PostEntity $postEntity): void
    {
        $this->postRepository->updateStatus($postEntity);
    }

    public function getPaginatedPostsOrderedById(bool $isStart, int $id = null): array
    {
        return $this->postRepository->getPaginatedPostsOrderedById($isStart, $id);
    }

    public function getPaginatedPostsByCategory(array $category): array
    {
        return $this->postRepository->getPaginatedPostsByCategory($category);
    }

    public function getAllPublishedPosts(): array
    {
        return Cache::rememberForever('latest-posts', function () {
            return $this->postRepository->getAllPublishedPosts();
        });
    }

    public function getPaginatedPostsWithoutCache(): array
    {
        return $this->postRepository->getPaginatedPostsWithoutCache();
    }

    public function getPostsForShow(string $slug): array
    {
        return $this->postRepository->getPostsForShow($slug);
    }

    public function getSuggests(array $ids): array
    {
        return $this->postRepository->getSuggests($ids);
    }

    public function search(string $query): array
    {
        return $this->postRepository->search($query);
    }

    public function getPostsForSitemap(): array
    {
        return Cache::rememberForever('posts-for-sitemap', function () {
            return $this->postRepository->getPostsForSitemap();
        });
    }

    public function incrementViews(int $postId): void
    {
        $this->postRepository->incrementViews($postId);
    }
}