<?php

namespace App\Repositories;

use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\DataTransferObjects\NewsCollection;
use App\Models\News;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NewsRepository implements NewsRepositoryInterface
{
    public function getLastNews(int $limit = 10): NewsCollection
    {
        $news = News::published()
            ->with('user')
            ->orderBy('date_published', 'desc')
            ->limit($limit)
            ->get();
            
        return new NewsCollection($news->toArray());
    }

    public function getPaginatedNews(int $perPage = 15): LengthAwarePaginator
    {
        return News::published()
            ->with('user')
            ->orderBy('date_published', 'desc')
            ->paginate($perPage);
    }

    public function findById(int $id): ?array
    {
        $news = News::with('user')->find($id);
        return $news ? $news->toArray() : null;
    }

    public function create(array $data): array
    {
        $news = News::create($data);
        return $news->toArray();
    }

    public function update(int $id, array $data): bool
    {
        $news = News::findOrFail($id);
        return $news->update($data);
    }

    public function delete(int $id): bool
    {
        $news = News::findOrFail($id);
        return $news->delete();
    }

    public function togglePublish(int $id): bool
    {
        $news = News::findOrFail($id);
        $news->is_published = !$news->is_published;
        return $news->save();
    }
}
