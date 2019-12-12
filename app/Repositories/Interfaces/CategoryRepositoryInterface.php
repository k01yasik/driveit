<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 29.10.2019
 * Time: 19:08
 */

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model as Model;

interface CategoryRepositoryInterface
{

    /**
     * @param mixed $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed|null|static|static[]
     */
    public function getPostCategory($id);

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllParentCategories();

    public function getCategoryByName(string $name): Model;
}