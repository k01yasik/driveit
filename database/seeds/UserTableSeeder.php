<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Album;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->username = config('admin.username');
        $user->email = config('admin.email');
        $user->password = Hash::make(config('admin.password'));
        $user->save();

        $album = new Album;
        $album->name = 'posts';
        $album->user()->associate($user);
        $album->save();
    }
}
