<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Album;
use App\Profile;

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

        $user = new User;
        $user->username = 'test';
        $user->email = 'test@mail.ru';
        $user->password = Hash::make('test');
        $user->save();

        $album = new Album;
        $album->name = 'posts';
        $album->user()->associate($user);
        $album->save();

        $profile = new Profile;
        $profile->user()->associate($user);
        $profile->avatar = '/photo/admin-avatar.jpg';
        $profile->public = false;
        $profile->save();
    }
}
