<?php


namespace App\Services\SortService\Interfaces;


use App\Services\SortService\PostSortByComments;
use App\Services\SortService\PostSortByRating;

interface SortFactory
{
    public function createPostSortByComments(): PostSortByComments;

    public function createPostSortByRating(): PostSortByRating;
}