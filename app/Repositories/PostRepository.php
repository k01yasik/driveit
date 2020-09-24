<?php

namespace App\Repositories;

use App\Category;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Post;
use App\Entities\Post as PostEntity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class PostRepository implements PostRepositoryInterface
{
    public function store(PostEntity $postEntity, int $userId, array $postCategoriesId): void
    {
        $post = new Post;
        $post->slug = $postEntity->getSlug();
        $post->title = $postEntity->getTitle();
        $post->description = $postEntity->getDescription();
        $post->name = $postEntity->getName();
        $post->caption = $postEntity->getCaption();
        $post->body = $postEntity->getBody();
        $post->image_path = $postEntity->getImagePath();
        $post->is_published = $postEntity->isPublished();
        $post->user_id = $userId;
        $post->views = $postEntity->getViews();
        $post->save();

        $post->categories()->attach($postCategoriesId);
    }

    public function update(PostEntity $postEntity, int $userId, int $postId, array $postCategoriesId): void
    {
        $post = Post::find($postId);
        $post->title = $postEntity->getTitle();
        $post->description = $postEntity->getDescription();
        $post->name = $postEntity->getName();
        $post->caption = $postEntity->getCaption();
        $post->body = $postEntity->getBody();
        $post->image_path = $postEntity->getImagePath();
        $post->user_id = $userId;
        $post->save();

        $post->categories()->detach();

        $post->categories()->attach($postCategoriesId);
    }

    public function updateStatus(PostEntity $postEntity): void
    {
        $post = Post::find($postEntity->getId());
        $post->is_published = $postEntity->isPublished();

        if ($date = $postEntity->getDatePublished()) {
            $post->date_published = $date;
        }

        $post->save();
    }

    public function updateHtml(PostEntity $postEntity, int $postId): void
    {
        $post = Post::find($postId);
        $post->body = clean($postEntity->getBody());
        $post->save();
    }

    public function getPostByIdWithUserData($postId): array
    {
        return Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('id', $postId)->first()->toArray();
    }

    public function getPostByIdWithCategories(int $postId): array
    {
        return Post::with('categories')->where('id', $postId)->first()->toArray();
    }

    public function getById(int $postId): array
    {
        return Post::find($postId)->toArray();
    }

    public function changePublishStatus(int $postId)
    {

    }

    public function getPaginatedPostsOrderedById(int $pageId, int $numberPosts): array
    {
        return Post::orderByDesc('id')
            ->skip(($pageId - 1) * $numberPosts)
            ->take($numberPosts)
            ->get()
            ->toArray();
    }

    public function getPostBySlugWithUserData(string $slug): array
    {
        return Post::with(['user', 'categories', 'user.profile'])->where('slug', $slug)->firstOrFail()->toArray();
    }

    public function getPaginatedPostsByCategory(array $category, int $pageId, int $numberPosts): array
    {
        return Category::find($category['id'])
            ->posts()
            ->with(['user', 'categories', 'user.profile', 'rating', 'comments'])
            ->where('is_published', 1)
            ->orderByDesc('date_published')
            ->skip(($pageId - 1) * $numberPosts)
            ->take($numberPosts)
            ->get()
            ->toArray();
    }

    public function getAllPublishedPosts(): array
    {
        return Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->orderByDesc('date_published')->get()->toArray();
    }

    public function getPostsForShow(string $slug): array
    {
        return Post::with(['user', 'categories', 'user.profile', 'rating', 'comments', 'suggest'])->where([['slug', $slug], ['is_published', 1]])->get()->toArray();
    }

    public function getSuggests(array $ids): array
    {
        return Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->find($ids)->toArray();
    }

    public function search(string $query): array
    {
        return Post::search($query)->get()->load(['user', 'categories', 'user.profile'])->toArray();
    }

    public function getPostsForSitemap(): array
    {
        return Post::where('is_published', 1)->orderByDesc('date_published')->get()->toArray();
    }

    public function incrementViews(int $postId): void
    {
        $post = Post::find($postId);

        if ($post instanceof Model) {
            $post->views += 1;
            $post->save();
        }
    }

    public function getTopPosts(int $count): array
    {
        return Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])
            ->where('is_published', true)
            ->orderByDesc('date_published')
            ->take($count)
            ->get()
            ->toArray();
    }

    public function getPostsForPage(int $pageId, int $numberPosts): array
    {
        return Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])
            ->where('is_published', true)
            ->orderByDesc('date_published')
            ->skip(($pageId - 1) * config('pagination.postsPerPage'))
            ->take($numberPosts)
            ->get()
            ->toArray();
    }

    public function getPostsSortedByViews(int $pageId, int $numberPosts): array
    {
        return Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])
            ->where('is_published', true)
            ->orderByDesc('views')
            ->skip(($pageId - 1) * config('pagination.postsPerPage'))
            ->take($numberPosts)
            ->get()
            ->toArray();
    }

    public function getPostsCount(): int
    {
        return Post::count();
    }

    public function getPostsCountByCategory(int $id): int
    {
        return Category::find($id)
            ->posts()->count();
    }
}