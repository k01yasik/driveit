<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 28.10.2019
 * Time: 20:43
 */

namespace App\Repositories\Interfaces;

use App\Post;

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
    public function update($id, Array $data);

    /**
     * @param mixed $id
     * @param array $data
     */
    public function updateHtml($id, Array $data);

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getPostByIdWithUserData($id);
}