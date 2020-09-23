<?php


namespace App\Services\SortService;


class Creator implements Interfaces\SortFactory
{

    public function createPostSortByComments(): PostSortByComments
    {
        return new PostSortByComments();
    }

    public function createPostSortByRating(): PostSortByRating
    {
        return new PostSortByRating();
    }
}