<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 18.08.2018
 * Time: 17:24
 */

namespace App\Services;


class FriendService
{
    public function getConfirmedFriends($friends)
    {
        $friendsArray = [];

        foreach ($friends as $friend) {
            if ($friend->confirmed) {
                array_push($friendsArray, $friend->friend_id);
            }
        }

        return $friendsArray;
    }

    public function getRequestedFriends($friends)
    {
        $friendsArray = [];

        foreach ($friends as $friend)
        {
            array_push($friendsArray, $friend->friend_id);
        }

        return $friendsArray;
    }
}