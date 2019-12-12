<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class SuggestsService
{
    public function getSuggestsIds(Model $post)
    {
        $suggest_ids = [];

        foreach ($post->suggest as $suggest) {
            array_push($suggest_ids, $suggest->suggest);
        }

        return $suggest_ids;
    }
}