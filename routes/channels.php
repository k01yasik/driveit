<?php

use App\Message;

Broadcast::channel('user.{id}', function ($user, $id) {

    return (int) $user->id === (int) $id;
});
