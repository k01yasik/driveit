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
        $user->name = 'Bzdykin';
        $user->email = 'bzdykin@mail.ru';
        $user->password = Hash::make('VcxzFdsa%432');
        $user->save();
    }
}
