<?php

namespace App\Services\Data;

class ImageData
{
    public function __construct(
        public readonly string $url,
        public readonly string $path,
        public readonly string $name,
        public readonly string $pathThumbnail,
        public readonly string $urlThumbnail,
        public readonly int $albumId
    ) {
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'path' => $this->path,
            'name' => $this->name,
            'path_thumbnail' => $this->pathThumbnail,
            'url_thumbnail' => $this->urlThumbnail,
            'album_id' => $this->albumId,
        ];
    }
}
