<?php


namespace App\Entities;


class Post
{
    private ?int    $id;
    private string  $slug;
    private string  $title;
    private string  $description;
    private string  $name;
    private string  $caption;
    private string  $body;
    private string  $imagePath;
    private bool    $isPublished;
    private int     $views;
    private ?string $datePublished;

    private function __construct(
                                 ?int   $id,
                                 string $slug,
                                 string $title,
                                 string $description,
                                 string $name,
                                 string $caption,
                                 string $body,
                                 string $imagePath,
                                 bool   $isPublished = false,
                                 int    $views = 0,
                                 ?string $datePublished = null)
    {
        $this->id =             $id;
        $this->slug =           $slug;
        $this->title =          $title;
        $this->description =    $description;
        $this->name =           $name;
        $this->caption =        $caption;
        $this->body =           $body;
        $this->imagePath =      $imagePath;
        $this->isPublished =    $isPublished;
        $this->views =          $views;
        $this->datePublished =  $datePublished;
    }

    public static function create(
                            ?int   $id,
                            string $slug,
                            string $title,
                            string $description,
                            string $name,
                            string $caption,
                            string $body,
                            string $imagePath)
    {
        return new self($id, $slug, $title, $description, $name, $caption, $body, $imagePath);
    }

    public static function restoreFromDb(
                            int    $id,
                            string $slug,
                            string $title,
                            string $description,
                            string $name,
                            string $caption,
                            string $body,
                            string $imagePath,
                            bool   $isPublished,
                            int    $views,
                            string $datePublished)
    {
        return new self($id, $slug, $title, $description, $name, $caption, $body, $imagePath, $isPublished, $views, $datePublished);
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    /**
     * @return int
     */
    public function getViews(): int
    {
        return $this->views;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getDatePublished(): ?string
    {
        return $this->datePublished;
    }
}