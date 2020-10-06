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

    public function getPaginatedPostsOrderedById(int $pageId, int $numberPosts): array
    {
        return $this->postRepository->getPaginatedPostsOrderedById($pageId, $numberPosts);
    }

    public function getPaginatedPostsByCategoryId(int $categoryId, int $pageId, int $numberPosts): array
    {
        return $this->postRepository->getPaginatedPostsByCategoryId($categoryId, $pageId, $numberPosts);
    }

    public function getAllPublishedPosts(): array
    {
        return Cache::rememberForever('latest-posts', function () {
            return $this->postRepository->getAllPublishedPosts();
        });
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

    public function getTopPosts(int $count): array
    {
        return Cache::rememberForever('top-posts', function () use ($count){
            return $this->postRepository->getTopPosts($count);
        });
    }

    public function getPostsForPage(int $pageId, int $numberPosts): array
    {
        return Cache::rememberForever('paginated-posts-'.$pageId, function () use ($pageId, $numberPosts) {
            return $this->postRepository->getPostsForPage($pageId, $numberPosts);
        });
    }

    public function getPostsCount(): int
    {
        return $this->postRepository->getPostsCount();
    }

    public function getPostsSortedByViews(int $pageId, int $numberPosts): array
    {
        return $this->postRepository->getPostsSortedByViews($pageId, $numberPosts);
    }

    public function getPostsCountByCategory(int $id): int
    {
        return $this->postRepository->getPostsCountByCategory($id);
    }

    public function getPostStatus(PostEntity $postEntity): bool
    {
        return Cache::rememberForever('post-status-'.$postEntity->getId(), function () use ($postEntity) {
            return $this->postRepository->getPostStatus($postEntity);
        });
    }

    public function publishPost(PostEntity $postEntity): void
    {
        $this->postRepository->publishPost($postEntity);
    }

    public function unpublishPost(PostEntity $postEntity): void
    {
        $this->postRepository->unpublishPost($postEntity);
    }
}