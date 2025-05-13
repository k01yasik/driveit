<?php

namespace App\Repositories;

use App\Draft as DraftModel;
use App\DTO\Draft as DraftDTO;
use App\Repositories\Interfaces\DraftRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DraftRepository implements DraftRepositoryInterface
{
    public function getUserDrafts(int $userId): array
    {
        return DraftModel::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    public function save(DraftDTO $draft, int $userId): void
    {
        $model = new DraftModel();
        $model->fill(array_merge(
            $draft->toArray(),
            ['user_id' => $userId]
        ));
        
        if (!$model->save()) {
            throw new \RuntimeException('Failed to save draft');
        }
    }
}
