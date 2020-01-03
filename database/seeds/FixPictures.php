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
            $profile->avatar = substr($profile->avatar, 0, -3).'webp';
            $profile->save();
        }

        $posts = Post::all();

        foreach ($posts as $post) {
            $post->image_path = substr($post->image_path,  0, -3).'webp';
            $post->save();
        }
    }
}
