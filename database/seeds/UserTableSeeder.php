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
        $user->username = config('admin.username');
        $user->email = config('admin.email');
        $user->password = Hash::make(config('admin.password'));
        $user->save();
    }
}
