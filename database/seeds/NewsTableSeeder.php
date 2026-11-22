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
        App\News::class::factory()->count(100)->create();
    }
}
