<?php

namespace App\Services;

class PathService
{
    private const THUMBNAIL_SUBPATH = 'thumbnail';
    private const AVATARS_SUBPATH = 'avatars';
    
    /**
     * Create a thumbnail path using structured components
     *
     * @param string $username
     * @param string $albumPath
     * @param string $imageName
     * @return string
     */
    public function createThumbnailPath(string $username, string $albumPath, string $imageName): string
    {
        return $this->buildPath([$username, $albumPath, self::THUMBNAIL_SUBPATH, $imageName]);
    }

    /**
     * Create an avatar path using structured components
     *
     * @param string $username
     * @param string $imageName
     * @return string
     */
    public function createAvatarPath(string $username, string $imageName): string
    {
        return $this->buildPath([$username, self::AVATARS_SUBPATH, $imageName]);
    }

    /**
     * Build path from components
     *
     * @param array $pathComponents
     * @return string
     */
    protected function buildPath(array $pathComponents): string
    {
        return implode('/', array_filter($pathComponents));
    }
}
