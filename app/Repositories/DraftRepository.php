<?php

namespace App\Repositories;

use App\Draft;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\DraftRepositoryInterface;
use App\Dto\Draft as DraftDto;

class DraftRepository implements DraftRepositoryInterface
{
    public function getUserDrafts(int $id): array
    {
        return Draft::where('user_id', $id)->get()->toArray();
    }


    public function save(DraftDto $draft, int $userId): void
    {
        $model = new Draft;
        $model->slug = $draft->slug;
        $model->title = $draft->title;
        $model->description = $draft->description;
        $model->name = $draft->name;
        $model->caption = $draft->caption;
        $model->body = $draft->body;
        $model->image = $draft->image;
        $model->user_id = $userId;
        $model->save();
    }
}