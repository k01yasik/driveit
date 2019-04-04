<?php

use Illuminate\Database\Seeder;
use App\Category;

class UpdateCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            Category::where('name', 'goods')->delete();
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }

        $category = new Category;
        $category->name = 'stores';
        $category->displayname = 'магазины';
        $category->has_child = 0;
        $category->save();
    }
}
