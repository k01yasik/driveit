<?php


Broadcast::channel('user.{id}', function ($user, $id) {

    return (int) $user->id === (int) $id;
});

Broadcast::channel('post.{id}', function ($user, $id) {
    if (Auth::check()) {
        return ['id' => $user->id, 'username' => $user->username, 'avatar' => $user->profile()->first()->avatar, 'url' => route('user.profile', ['username' => $user->username])];
    }
    return false;
});
