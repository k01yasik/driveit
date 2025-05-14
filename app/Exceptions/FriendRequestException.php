// app/Exceptions/FriendRequestException.php
<?php

namespace App\Exceptions;

use Exception;

class FriendRequestException extends Exception
{
    public static function alreadyFriends(): self
    {
        return new self('Users are already friends');
    }

    public static function requestAlreadySent(): self
    {
        return new self('Friend request already sent');
    }
}
