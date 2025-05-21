<?php

namespace App\DTO;

class DraftDTO
{
    public function __construct(
        private string $slug,
        private string $title,
        private string $description,
        private string $name,
        private string $caption,
        private string $body,
        private string $image
    ) {}

    public function toArray(): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'name' => $this->name,
            'caption' => $this->caption,
            'body' => $this->body,
            'image' => $this->image,
        ];
    }

    public function getSlug(): string { return $this->slug; }
    public function getTitle(): string { return $this->title; }
    public function getDescription(): string { return $this->description; }
    public function getName(): string { return $this->name; }
    public function getCaption(): string { return $this->caption; }
    public function getBody(): string { return $this->body; }
    public function getImage(): string { return $this->image; }
}
