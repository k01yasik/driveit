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
        $post = Post::find(92);
        $post->image_path = substr($post->image_path,  0, -1);
        $post->save();
    }
}
