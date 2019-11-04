<?php

use Illuminate\Database\Seeder;
use App\User;

class GrantAdminPrivilegies extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('username', 'Bzdykin')->firstOrFail();
        $user->assignRole('admin');
    }
}
