<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 28.10.2019
 * Time: 20:43
 */

namespace App\Repositories;


use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Post;
use App\Services\PostService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Laravel\Scout\Builder;

class PostRepository implements PostRepositoryInterface
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @param array $data
     * @return Post
     */
    public function store(Array $data)
    {
        $post = new Post;
        $post->slug = $data['slug'];
        $post->title = $data['title'];
        $post->description = $data['description'];
        $post->name = $data['name'];
        $post->caption = $data['caption'];
        $post->body = $data['body'];
        $post->image_path = $data['image'];
        $post->is_published = 0;
        $post->user()->associate(Auth::user());
        $post->views = 0;
        $post->save();

        return $post;
    }

    /**
     * @param mixed $id
     * @param array $data
     * @return Post $post
     */
    public function update($id, Array $data): Post
    {
        $post = Post::find($id);
        $post->title = $data['title'];
        $post->description = $data['description'];
        $post->name = $data['name'];
        $post->caption = $data['caption'];
        $post->body = $data['body'];
        $post->image_path = $data['image'];
        $post->user()->associate(Auth::user());
        $post->save();

        return $post;
    }

    /**
     * @param mixed $id
     * @param array $data
     */
    public function updateHtml($id, Array $data): void
    {
        $post = Post::find($id);
        $post->body = clean($data['html']);
        $post->save();
    }

    /**
     * @param $id
     * @return Post $post;
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getPostByIdWithUserData($id): Post
    {
        $post = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('id', $id)->firstOrFail();

        return $post;
    }

    /**
     * @param $id
     * @return Post $post;
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getPostByIdWithCategories($id)
    {
        $post = Post::with('categories')->where('id', $id)->firstOrFail();

        return $post;
    }

    /**
     * @param int $id
     * @return Post
     */
    public function getById(int $id)
    {
        return Post::find($id);
    }

    /**
     * @param Post $post
     * @return Post
     */
    public function togglePublish(Post $post)
    {
        if ($post->is_published) {
            $post->is_published = 0;
        } else {
            $post->is_published = 1;
            $post->date_published = Carbon::now();
        }

        return $post;
    }


    /**
     * @param bool $isStart
     * @param int|null $id
     * @return Paginator
     */
    public function getPaginatedPostsOrderedById(bool $isStart, int $id =  null): Paginator
    {
        $posts = Post::orderByDesc('id');

        if ($isStart) {
            return $posts->paginate(10);
        }

        return $posts->paginate(10, ['*'], 'page', $id);

    }



    /**
     * @param string $slug
     * @return Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getPostBySlugWithUserData(string $slug): Model
    {
        $post = Post::with(['user', 'categories', 'user.profile'])->where('slug', $slug)->firstOrFail();

        return $post;
    }


    /**
     * @param Model $model
     * @param bool $isStart
     * @param int|null $id
     * @return Paginator
     */
    public function getPaginatedPostsByCategory(Model $model, bool $isStart, int $id = null): Paginator
    {
        $posts = $model->posts()->with(['user', 'categories', 'user.profile'])->where('is_published', 1)->orderByDesc('date_published');

        if ($isStart) {
            return $posts->paginate(10);
        }

        return $posts->paginate(10, ['*'], 'page', $id);
    }


    /**
     * @return Paginator
     */
    public function getPaginatedPostsForPages(): Paginator
    {
        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->orderByDesc('date_published')->paginate(10);

        foreach ($posts as $post) {
            $this->postService->countPostRating($post);
            $this->postService->countPostComments($post);
        }

        return $posts;
    }

    /**
     * @return Paginator
     */
    public function getPaginatedPostsWithoutCache(int $id): Paginator
    {
        return Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->orderByDesc('date_published')->paginate(10, ['*'], 'page', $id);
    }

    /**
     * @return Collection
     */
    public function getPostCollection(): Collection
    {
        return Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->get();
    }

    public function getPostsForShow(string $slug): Model
    {
        return Post::with(['user', 'categories', 'user.profile', 'rating', 'comments', 'suggest'])->where([['slug', $slug], ['is_published', 1]])->firstOrFail();
    }

    /**
     * @param array $ids
     * @return Collection
     */
    public function getSuggests(array $ids): Collection
    {
        return Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->find($ids);
    }

    /**
     * @param string $query
     * @return Builder
     */
    public function search(string $query): Builder
    {
        return Post::search($query)->paginate(10)->load(['user', 'categories', 'user.profile']);
    }

    /**
     * @return Collection
     */
    public function getPostsForSitemap(): Collection
    {
        return Post::where('is_published', 1)->orderByDesc('date_published')->get();
    }
}