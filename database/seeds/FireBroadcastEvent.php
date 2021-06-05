<?php

namespace Database\Seeders;

use App\Events\ConfirmFriendRequest;
use App\User;
use Illuminate\Database\Seeder;

class FireBroadcastEvent extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::find(1);
        $user2 = User::find(2);

        broadcast(new ConfirmFriendRequest($user1, $user2));

        broadcast(new ConfirmFriendRequest($user2, $user1));
    }
}
