<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\CommentDTO;
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

    public function update(CommentUpdateDTO $commentData): void
    {
        Comment::where('id', $commentData->id)
            ->update([
                'user_id' => $commentData->userId,
                'post_id' => $commentData->postId,
                'message' => $commentData->message,
                'is_verified' => $commentData->isVerified,
                'level' => $commentData->level,
                'parent_id' => $commentData->parentId
            ]);
    }

    public function create(CommentDTO $commentData): array
    {
        $comment = new Comment();
        $comment->user_id = $commentData->userId;
        $comment->post_id = $commentData->postId;
        $comment->message = $commentData->message;
        $comment->is_verified = $commentData->isVerified;
        $comment->level = $commentData->level;
        $comment->parent_id = $commentData->parentId;
        $comment->save();

        return $comment->load('user.profile')->toArray();
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

    public function bulkVerify(array $ids): int
    {
        return Comment::whereIn('id', $ids)
            ->update(['is_verified' => true]);
    }
}
