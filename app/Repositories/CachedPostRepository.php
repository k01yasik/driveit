<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 24.11.2019
 * Time: 21:28
 */

namespace App\Repositories;


use App\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Builder;

class CachedPostRepository implements PostRepositoryInterface
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param array $data
     * @return Post $post
     */
    public function store(Array $data)
    {
        return $this->postRepository->store($data);
    }

    /**
     * @param mixed $id
     * @param array $data
     * @return Post $post
     */
    public function update($id, Array $data): Post
    {
        return $this->postRepository->update($id, $data);
    }

    /**
     * @param mixed $id
     * @param array $data
     */
    public function updateHtml($id, Array $data): void
    {
        $this->postRepository->updateHtml($id, $data);
    }

    /**
     * @param $id
     * @return Post $post;
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getPostByIdWithUserData($id): Post
    {
        return $this->postRepository->getPostByIdWithUserData($id);
    }

    /**
     * @param $id
     * @return Post $post;
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getPostByIdWithCategories($id)
    {
        return $this->postRepository->getPostByIdWithCategories($id);
    }

    /**
     * @param string $slug
     * @return Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getPostBySlugWithUserData(string $slug): Model
    {
        return $this->postRepository->getPostBySlugWithUserData($slug);
    }

    /**
     * @param int $id
     * @return Post
     */
    public function getById(int $id)
    {
        return $this->postRepository->getById($id);
    }

    /**
     * @param Post $post
     * @return Post
     */
    public function togglePublish(Post $post)
    {
        return $this->postRepository->togglePublish($post);
    }

    /**
     * @param bool $isStart
     * @param int|null $id
     * @return Paginator
     */
    public function getPaginatedPostsOrderedById(bool $isStart, int $id = null): Paginator
    {
        return $this->postRepository->getPaginatedPostsOrderedById($isStart, $id);
    }

    /**
     * @param Model $model
     * @param bool $isStart
     * @param int|null $id
     * @return Paginator
     */
    public function getPaginatedPostsByCategory(Model $model, bool $isStart, int $id = null): Paginator
    {
        return $this->postRepository->getPaginatedPostsByCategory($model, $isStart, $id);
    }


    /**
     * @return Paginator
     */
    public function getPaginatedPostsForPages(): Paginator
    {
        return Cache::rememberForever('latest-posts', function () {
            return $this->postRepository->getPaginatedPostsForPages();
        });
    }

    /**
     * @param int $id
     * @return Paginator
     */
    public function getPaginatedPostsWithoutCache(int $id): Paginator
    {
        return $this->postRepository->getPaginatedPostsWithoutCache($id);
    }

    /**
     * @return Collection
     */
    public function getPostCollection(): Collection
    {
        return $this->postRepository->getPostCollection();
    }

    /**
     * @param string $slug
     * @return Model
     */
    public function getPostsForShow(string $slug): Model
    {
        return $this->postRepository->getPostsForShow($slug);
    }

    /**
     * @param array $ids
     * @return Collection
     */
    public function getSuggests(array $ids): Collection
    {
        $this->postRepository->getSuggests($ids);
    }

    /**
     * @param string $query
     * @return Builder
     */
    public function search(string $query): Builder
    {
        return $this->postRepository->search($query);
    }

    /**
     * @return Collection
     */
    public function getPostsForSitemap(): Collection
    {
        return Cache::rememberForever('posts-for-sitemap', function () {
            return $this->postRepository->getPostsForSitemap();
        });
    }
}