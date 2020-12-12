<?php

namespace App\Repositories\Interfaces;

use App\Post;
use App\Entities\Post as PostEntity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

interface PostRepositoryInterface
{
    public function store(PostEntity $post, int $userId, array $postCategoriesId): void;

    public function update(PostEntity $post, int $userId, int $postId, array $postCategoriesId): void;

    public function updateHtml(PostEntity $postEntity, int $postId): void;

    public function getPostByIdWithUserData(int $postId): array;

    public function getPostByIdWithCategories(int $postId): array;

    public function getPostBySlugWithUserData(string $slug): array;

    public function getById(int $postId): array;

    public function getPaginatedPostsOrderedById(int $pageId, int $numberPosts): array;

    public function getPaginatedPostsByCategoryId(int $categoryId, int $pageId, int $numberPosts): array;

    public function getAllPublishedPosts(): array;

    public function getPostsByMonth(): array;

    public function getPostsForShow(string $slug): array;

    public function getSuggests(array $ids): array;

    public function search(string $query): array;

    public function getPostsForSitemap(): array;

    public function incrementViews(int $postId): void;

    public function getTopPosts(int $count): array;

    public function getPostsForPage(int $pageId, int $numberPosts): array;

    public function getPostsCount(): int;

    public function getPostsSortedByViews(int $pageId, int $numberPosts): array;

    public function getPostStatus(PostEntity $postEntity): bool;

    public function publishPost(PostEntity $postEntity): void;

    public function unpublishPost(PostEntity $postEntity): void;
}