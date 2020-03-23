<?php

namespace App\Repositories;

use App\Draft;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\DraftRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DraftRepository implements DraftRepositoryInterface
{
    public function getUserDrafts(): Collection
    {
        return Draft::where('user_id', Auth::id())->get();
    }


    public function store(array $data): bool
    {
        $draft = new Draft;
        if (isset($data['slug'])) $draft->slug = $data['slug'];
    }
}