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
        $profiles = Profile::all();

        foreach ($profiles as $profile) {
            $profile->avatar = substr_replace($profile->avatar, 'web-rookie.ru', 8, 14);
            $profile->save();
        }

        $posts = Post::all();

        foreach ($posts as $post) {
            $post->image_path = substr_replace($post->image_path, 'web-rookie.ru', 8, 14);
            $post->save();
        }
    }
}
