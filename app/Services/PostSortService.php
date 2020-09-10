<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class PostSortService
{
    public function sortedBy(array $collection, $criteria)
    {
        if ($criteria == 'posts.rated') {
            foreach ($collection as $col) {
                $col->setAttribute('rat', $col->rating->count());
                $col->setAttribute('seconds', strtotime($col->getOriginal('date_published')));
            }

            $collection = array_values($collection);

            $array_column = array_column($collection, 'rat');
            array_multisort($array_column, SORT_DESC, array_column($collection, 'seconds'), SORT_DESC, $collection);
            
            $collection = collect($collection);

        } elseif ($criteria == 'posts.views') {
            foreach ($collection as $col) {
                $col->setAttribute('seconds', strtotime($col->getOriginal('date_published')));
            }

            $collection = array_values($collection);

            $array_column1 = array_column($collection, 'views');
            array_multisort($array_column1, SORT_DESC, array_column($collection, 'seconds'), SORT_DESC, $collection);
            
            $collection = collect($collection);

        } elseif ($criteria == 'posts.comments') {
            foreach ($collection as $col) {
                $col->setAttribute('comment', $col->comments->count());
                $col->setAttribute('seconds', strtotime($col->getOriginal('date_published')));
            }

            $collection = array_values($collection);

            $array_column2 = array_column($collection, 'comment');
            array_multisort($array_column2, SORT_DESC, array_column($collection, 'seconds'), SORT_DESC, $collection);

            $collection = collect($collection);
        }

        return $collection;
    }

    public function getSlicedData(string $name, array $posts, int $count)
    {
        if ($name == 'posts.rated') {

            $posts = $this->sortedBy($posts, 'posts.rated');

            $posts = $posts->slice( 0, $count);

        } else if ($name == 'posts.views') {

            $posts = $this->sortedBy($posts, 'posts.views');

            $posts = $posts->slice(0, $count);

        } else {

            $posts = $this->sortedBy($posts, 'posts.comments');

            $posts = $posts->slice(0, $count);

        }

        return $posts;
    }
}