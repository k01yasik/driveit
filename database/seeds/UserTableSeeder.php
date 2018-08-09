<?php

use Illuminate\Database\Seeder;
use App\User;

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
        $user->username = env('ADMIN_USERNAME');
        $user->email = env('ADMIN_EMAIL');
        $user->password = Hash::make(env('ADMIN_PASSWORD'));
        $user->save();
    }
}
