<?php

use Illuminate\Database\Seeder;
use App\Profile;
use App\Post;

class FixPictures extends Seeder
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
            $post->image_path = substr($post->image_path,  0, -5);
            $post->save();
        }
    }
}
