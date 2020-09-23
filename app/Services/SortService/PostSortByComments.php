<?php


namespace App\Services\SortService;


use App\Services\SortService\Interfaces\Sort;

class PostSortByComments implements Sort
{
    public function sort(array $posts): array
    {
        $array_column = array_column($posts, 'comments_count');

        array_multisort($array_column, SORT_DESC,
                            array_column($posts, 'updated_at'), SORT_DESC,
                            $posts
        );

        return $posts;
    }
}