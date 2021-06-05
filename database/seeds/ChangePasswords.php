<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ChangePasswords extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(2);
        $user->password = Hash::make('hello');
        $user->save();

        $user = User::find(3);
        $user->password = Hash::make('sunny');
        $user->save();
    }
}
