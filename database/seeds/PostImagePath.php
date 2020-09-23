<?php

namespace Database\Seeders;

use App\Post;
use Illuminate\Database\Seeder;

class PostImagePath extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::all();

        foreach ($posts as $post) {
            $post->image_path = $post->image_path.'.webp';
            $post->save();
        }
    }
}
