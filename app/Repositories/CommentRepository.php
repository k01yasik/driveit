<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\CommentUpdateDTO;
use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CommentRepository implements CommentRepositoryInterface
{
    public function getById(int $id): array
    {
        return Comment::with(['user.profile'])
            ->findOrFail($id)
            ->toArray();
    }

    public function update(CommentUpdateDTO $comment): void
    {
        Comment::where('id', $comment->id)
            ->update([
                'user_id' => $comment->userId,
                'post_id' => $comment->postId,
                'message' => $comment->message,
                'is_verified' => $comment->isVerified,
                'level' => $comment->level,
                'parent_id' => $comment->parentId
            ]);
    }

    public function create(array $comment): array
    {
        return Comment::create($comment)
            ->load('user.profile')
            ->toArray();
    }

    public function getVerifiedCount(): int
    {
        return Comment::verified()->count();
    }

    public function getUnverifiedCount(): int
    {
        return Comment::unverified()->count();
    }

    public function getByPostId(int $postId): array
    {
        return Comment::with(['user.profile'])
            ->where('post_id', $postId)
            ->orderBy('created_at')
            ->get()
            ->toArray();
    }

    public function getPaginated(?int $page = null): LengthAwarePaginator
    {
        return Comment::with(['user.profile', 'post'])
            ->latest()
            ->paginate(
                config('pagination.comments_per_page'),
                ['*'],
                'page',
                $page
            );
    }

    public function getUnverified(): array
    {
        return Comment::with(['user.profile'])
            ->unverified()
            ->latest()
            ->get()
            ->toArray();
    }

    public function exists(int $id): bool
    {
        return Comment::where('id', $id)->exists();
    }

    public function isParentValid(int $parentId, int $postId): bool
    {
        return Comment::where('id', $parentId)
            ->where('post_id', $postId)
            ->exists();
    }

    // Опционально: пакетное обновление
    public function bulkVerify(array $ids): int
    {
        return Comment::whereIn('id', $ids)
            ->update(['is_verified' => true]);
    }
}
