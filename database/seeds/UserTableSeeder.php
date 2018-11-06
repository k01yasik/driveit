<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
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
        $user->email_verified_at = Carbon::now();
        $user->save();

        $album = new Album;
        $album->name = 'post';
        $album->path = str_random(10);
        $album->user()->associate($user);
        $album->save();

        $profile = new Profile;
        $profile->user()->associate($user);
        $profile->avatar = config('app.url').'/storage/Bzdykin/avatars/admin-avatar.jpg';
        $profile->public = true;
        $profile->save();

        $user = new User;
        $user->username = 'test1';
        $user->email = 'test1@mail.ru';
        $user->password = Hash::make('test1');
        $user->email_verified_at = Carbon::now();
        $user->save();

        $album = new Album;
        $album->name = 'post';
        $album->path = str_random(10);
        $album->user()->associate($user);
        $album->save();

        $profile = new Profile;
        $profile->user()->associate($user);
        $profile->avatar = config('app.url').'/storage/avatars/user.svg';
        $profile->public = true;
        $profile->save();

        $user = new User;
        $user->username = 'test2';
        $user->email = 'test2@mail.ru';
        $user->password = Hash::make('test2');
        $user->email_verified_at = Carbon::now();
        $user->save();

        $album = new Album;
        $album->name = 'post';
        $album->path = str_random(10);
        $album->user()->associate($user);
        $album->save();

        $profile = new Profile;
        $profile->user()->associate($user);
        $profile->avatar = config('app.url').'/storage/avatars/user.svg';
        $profile->public = true;
        $profile->save();
    }
}
