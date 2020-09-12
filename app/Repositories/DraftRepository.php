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
        $model->slug = $draft->getSlug();
        $model->title = $draft->getTitle();
        $model->description = $draft->getDescription();
        $model->name = $draft->getName();
        $model->caption = $draft->getCaption();
        $model->body = $draft->getBody();
        $model->image = $draft->getImage();
        $model->user_id = $userId;
        $model->save();
    }
}