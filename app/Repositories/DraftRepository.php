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
        if (isset($data['title'])) $draft->title = $data['title'];
        if (isset($data['description'])) $draft->description = $data['description'];
        if (isset($data['name'])) $draft->name = $data['name'];
        if (isset($data['caption'])) $draft->caption = $data['caption'];
        if (isset($data['body'])) $draft->body = $data['body'];
        if (isset($data['image'])) $draft->image = $data['image'];
        $draft->user()->associate(Auth::user());
        $draft->save();

        return true;
    }
}