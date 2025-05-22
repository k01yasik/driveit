<?php


namespace App\Services\SortService;


use App\Services\SortService\Interfaces\Sort;

class PostSortByComments implements Sort
{
    public function sort(array $posts): array
    {
        usort($posts, function ($a, $b) {
        // First sort by comments_count DESC
            if ($a['comments_count'] != $b['comments_count']) {
                return $b['comments_count'] <=> $a['comments_count'];
            }
            // Then sort by updated_at DESC
            return $b['updated_at'] <=> $a['updated_at'];
        });
    
        return $posts;
    }
}
