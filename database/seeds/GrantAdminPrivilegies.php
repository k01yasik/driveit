<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;

class GrantAdminPrivilegies extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        
        $user = User::where('username', 'Bzdykin')->firstOrFail();
        $user->assignRole('admin');
    }
}
