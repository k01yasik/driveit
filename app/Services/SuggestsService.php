<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class SuggestsService
{
    public function getSuggestsIds(array $post)
    {
        $suggestIds = [];

        foreach ($post['suggest'] as $suggest) {
            $suggestIds[] = $suggest['suggest'];
        }

        return $suggestIds;
    }
}