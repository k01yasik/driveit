// app/Events/Contracts/FriendRequestEvent.php
<?php

namespace App\Events\Contracts;

interface FriendRequestEvent
{
    public function getSender();
    public function getRecipient();
}
