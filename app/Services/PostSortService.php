<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class PostSortService
{
    public function sortedBy(Collection $collection, $criteria)
    {
        if ($criteria == 'posts.rated') {
            foreach ($collection as $col) {
                $col->setAttribute('rat', $col->rating->count());
                $col->setAttribute('seconds', strtotime($col->getOriginal('date_published')));
            }

            $collection = $collection->values()->all();

            array_multisort(array_column($collection, 'rat'), SORT_DESC, array_column($collection, 'seconds'), SORT_DESC, $collection);
            
            $collection = collect($collection);

        } elseif ($criteria == 'posts.views') {
            foreach ($collection as $col) {
                $col->setAttribute('seconds', strtotime($col->getOriginal('date_published')));
            }

            $collection = $collection->values()->all();

            array_multisort(array_column($collection, 'views'), SORT_DESC, array_column($collection, 'seconds'), SORT_DESC, $collection);
            
            $collection = collect($collection);

        } elseif ($criteria == 'posts.comments') {
            foreach ($collection as $col) {
                $col->setAttribute('comment', $col->comments->count());
                $col->setAttribute('seconds', strtotime($col->getOriginal('date_published')));
            }

            $collection = $collection->values()->all();

            array_multisort(array_column($collection, 'comment'), SORT_DESC, array_column($collection, 'seconds'), SORT_DESC, $collection);

            $collection = collect($collection);
        }

        return $collection;
    }
}