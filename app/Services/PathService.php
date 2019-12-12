<?php

namespace App\Services;


class PathService
{
    public function createThumbnailPath(string $username, string $albumPath, string $imageName) {
        return $username.'/'.$albumPath.'/thumbnail/'.$imageName;
    }

    public function createAvatarPath(string $username, string $imageName){
        return $username.'/avatars/'.$imageName;
    }
}