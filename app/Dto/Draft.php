<?php


namespace App\Dto;


class Draft
{
    private $slug;
    private $title;
    private $description;
    private $name;
    private $caption;
    private $body;
    private $image;

    /**
     * Draft constructor.
     * @param $slug
     * @param $title
     * @param $description
     * @param $name
     * @param $caption
     * @param $body
     * @param $image
     */
    public function __construct($slug, $title, $description, $name, $caption, $body, $image)
    {
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->name = $name;
        $this->caption = $caption;
        $this->body = $body;
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }
}