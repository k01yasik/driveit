<?php

use Illuminate\Database\Seeder;
use App\News;
use App\User;
use Carbon\Carbon;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\News::class, 100)->create();
    }
}
