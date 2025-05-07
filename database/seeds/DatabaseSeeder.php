<?php

use Database\Seeders\ChangePasswords;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            //UserTableSeeder::class,
            //SuggestTableSeeder::class,
            //\Database\Seeders\PostImagePath::class
            //ChangePasswords::class
            //\Database\Seeders\FireBroadcastEvent::class,
            UserTableSeeder::class,
            SeoTableSeeder::class,
            CategoryTableSeeder::class,
            PostTableSeeder::class
        ]);
    }
}
