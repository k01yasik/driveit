<?php

namespace App\Repositories;

use App\Category;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Post;
use App\Entities\Post as PostEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostRepository implements PostRepositoryInterface
{
    public function store(PostEntity $postEntity, int $userId, array $postCategoriesId): void
    {
        DB::transaction(function () use ($postEntity, $userId, $postCategoriesId): void {
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
        });
    }

    public function update(PostEntity $postEntity, int $userId, int $postId, array $postCategoriesId): void
    {
        DB::transaction(function () use ($postEntity, $userId, $postId, $postCategoriesId): void {
            $post = Post::lockForUpdate()->findOrFail($postId);
            $post->title = $postEntity->getTitle();
            $post->description = $postEntity->getDescription();
            $post->name = $postEntity->getName();
            $post->caption = $postEntity->getCaption();
            $post->body = $postEntity->getBody();
            $post->image_path = $postEntity->getImagePath();
            $post->user_id = $userId;
            $post->save();

            $post->categories()->sync($postCategoriesId);
        });
    }

    public function getPostStatus(PostEntity $postEntity): bool
    {
        return (bool) Post::select('is_published')->findOrFail($postEntity->getId())->is_published;
    }

    public function setPublication(int $postId, bool $published): void
    {
        DB::transaction(function () use ($postId, $published): void {
            $post = Post::lockForUpdate()->findOrFail($postId);
            abort_if($published && $post->archived_at !== null, 409, 'Восстановите пост из архива перед публикацией.');

            if ($post->isPublished() !== $published) {
                $post->is_published = $published;
                $post->date_published = $published ? now() : null;
                $post->save();
            }
        });
    }

    public function setArchived(int $postId, bool $archived): void
    {
        DB::transaction(function () use ($postId, $archived): void {
            $post = Post::lockForUpdate()->findOrFail($postId);

            if (($post->archived_at !== null) === $archived) {
                return;
            }

            $post->archived_at = $archived ? now() : null;
            $post->is_published = false;
            $post->date_published = null;
            $post->save();
        });
    }

    public function updateHtml(PostEntity $postEntity, int $postId): void
    {
        $post = Post::findOrFail($postId);
        $post->body = clean($postEntity->getBody());
        $post->save();
    }

    public function getPostByIdWithUserData(int $postId): array
    {
        return Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->findOrFail($postId)->toArray();
    }

    public function getPostByIdWithCategories(int $postId): array
    {
        return Post::with('categories')->findOrFail($postId)->toArray();
    }

    public function getById(int $postId): array
    {
        return Post::findOrFail($postId)->toArray();
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
        $post = Post::with([
            'user', 
            'categories', 
            'user.profile', 
            'rating', 
            'comments', 
            'suggest'
        ])
        ->where('slug', $slug)
        ->where('is_published', 1)
        ->first(); 
    
        if (!$post) {
            abort(404);
        }

        return $post->toArray();
    }

    public function getPaginatedPostsByCategoryId(int $categoryId, int $pageId, int $numberPosts): array
    {
        return Category::findOrFail($categoryId)
            ->posts()
            ->with(['user', 'categories', 'user.profile', 'rating', 'comments'])
            ->where('is_published', 1)
            ->orderByDesc('date_published')
            ->orderByDesc('posts.id')
            ->skip(($pageId - 1) * $numberPosts)
            ->take($numberPosts)
            ->get()
            ->toArray();
    }

    public function getAllPublishedPosts(): array
    {
        return Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->orderByDesc('date_published')->get()->toArray();
    }

    public function getPostsByMonth(): array
    {
        $start = now()->startOfMonth();

        return Post::with(['user.profile', 'categories', 'rating', 'comments'])
            ->where('is_published', true)
            ->where('date_published', '>=', $start)
            ->where('date_published', '<', $start->copy()->addMonth())
            ->orderByDesc('date_published')
            ->get()
            ->toArray();
    }

    public function getPostsForShow(string $slug): array
    {
        return Post::with(['user', 'categories', 'user.profile', 'rating', 'comments', 'suggest'])->where([['slug', $slug], ['is_published', 1]])->get()->toArray();
    }

    public function getSuggests(array $ids): array
    {
        return Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', true)->find($ids)->toArray();
    }

    public function search(string $query): array
    {
        return Post::search($query)->get()->filter(fn (Post $post): bool => $post->isPublished())->values()->load(['user', 'categories', 'user.profile', 'rating', 'comments'])->toArray();
    }

    public function getPostsForSitemap(): array
    {
        return Post::select(['slug', 'name', 'image_path', 'caption'])->where('is_published', 1)->orderByDesc('date_published')->get()->toArray();
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
            ->orderByDesc('posts.id')
            ->skip(($pageId - 1) * $numberPosts)
            ->take($numberPosts)
            ->get()
            ->toArray();
    }

    public function getPostsSortedByViews(int $pageId, int $numberPosts): array
    {
        return Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])
            ->where('is_published', true)
            ->orderByDesc('views')
            ->orderByDesc('posts.id')
            ->skip(($pageId - 1) * $numberPosts)
            ->take($numberPosts)
            ->get()
            ->toArray();
    }

    public function getPostsCount(): int
    {
        return Post::count();
    }

    public function getPublishedPostsCount(): int
    {
        return Post::where('is_published', true)->count();
    }

    public function getPostsCountByCategory(int $id): int
    {
        return Category::findOrFail($id)
            ->posts()->where('is_published', true)->count();
    }
}
