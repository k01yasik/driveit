<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 28.10.2019
 * Time: 20:43
 */

namespace App\Repositories\Interfaces;

use App\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

interface PostRepositoryInterface
{
    /**
     * @param array $data
     * @return Post $post
     */
    public function store(Array $data);

    /**
     * @param mixed $id
     * @param array $data
     * @return Post $post
     */
    public function update($id, Array $data): Post;

    /**
     * @param mixed $id
     * @param array $data
     */
    public function updateHtml($id, Array $data): void;

    /**
     * @param $id
     * @return Post $post;
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getPostByIdWithUserData($id): Post;

    /**
     * @param $id
     * @return Post $post;
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getPostByIdWithCategories($id);

    /**
     * @param string $slug
     * @return Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getPostBySlugWithUserData(string $slug): Model;

    /**
     * @param int $id
     * @return Post
     */
    public function getById(int $id);

    public function togglePublish(Post $post);

    public function getPaginatedPostsOrderedById(bool $isStart, int $id = null): Paginator;

    public function getPaginatedPostsByCategory(array $category): Builder;

    public function getPaginatedPostsForPages(): Paginator;

    public function getPaginatedPostsWithoutCache(int $id): Paginator;

    /**
     * @return Collection
     */
    public function getPostCollection(): Collection;

    /**
     * @param string $slug
     * @return Model
     */
    public function getPostsForShow(string $slug): Model;

    /**
     * @param array $ids
     * @return Collection
     */
    public function getSuggests(array $ids): Collection;

    /**
     * @param string $query
     * @return Builder
     */
    public function search(string $query): Builder;

    /**
     * @return Collection
     */
    public function getPostsForSitemap(): Collection;
}