<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 29.10.2019
 * Time: 19:08
 */

namespace App\Repositories;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @param mixed $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed|null|static|static[]
     */
    public function getPostCategory($id)
    {
        return Category::find($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllParentCategories()
    {
        return Category::hasChild()->get();
    }

    public function getCategoryByName(string $name): Model
    {
        return Category::where('name', $name)->firstOrFail();
    }
}