<?php

use Illuminate\Database\Seeder;
use App\Suggest;
use App\Post;

class SuggestTableSeeder extends Seeder
{

    public function run()
    {
        $posts = Post::all()->count();

        for ($i = 1; $i <= $posts; $i++ ) {

            $post_entry = Post::with('categories')->find($i)->categories;

            $category_id = 0;

            foreach ($post_entry as $entry) {
                $category_id = $entry->id;
            }

            $post_id_array = [];
            $posts_id = DB::table('category_post')->where('category_id', $category_id)->get();

            foreach ($posts_id as $post) {
                array_push($post_id_array, $post->post_id);
            }

            $count_array = count($post_id_array);

            if ($count_array > 3) {
                for ($p = 1; $p <= 3; $p++) {

                    $pp = new Suggest;
                    $pp->post_id = $i;
                    $pp->suggest = $post_id_array[random_int(0, $count_array-1)];
                    $pp->save();
                }
            }

        }

        $pp = new Suggest;
        $pp->post_id = 5;
        $pp->suggest = 70;
        $pp->save();

        $pp = new Suggest;
        $pp->post_id = 5;
        $pp->suggest = 89;
        $pp->save();

        $pp = new Suggest;
        $pp->post_id = 5;
        $pp->suggest = 87;
        $pp->save();

        $pp = new Suggest;
        $pp->post_id = 70;
        $pp->suggest = 5;
        $pp->save();

        $pp = new Suggest;
        $pp->post_id = 70;
        $pp->suggest = 86;
        $pp->save();

        $pp = new Suggest;
        $pp->post_id = 70;
        $pp->suggest = 85;
        $pp->save();
    }
}
