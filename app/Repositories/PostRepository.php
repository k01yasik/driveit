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
use Illuminate\Support\Facades\Auth;

class PostRepository implements PostRepositoryInterface
{

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
    public function update($id, Array $data)
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
    public function updateHtml($id, Array $data)
    {
        $post = Post::find($id);
        $post->body = clean($data['html']);
        $post->save();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getPostByIdWithUserData($id)
    {
        $post = Post::with(['user', 'categories', 'user.profile'])->where('id', $id)->firstOrFail();
        return $post;
    }
}