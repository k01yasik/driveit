<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CommentRepository implements CommentRepositoryInterface
{
    public function getById(int $id): array
    {
        return Comment::findOrFail($id)->toArray();
    }

    public function create(CommentDTO $dto): array {
    return Comment::create([
        'user_id' => $dto->userId,
        'post_id' => $dto->postId,
        'message' => $dto->message,
        'is_verified' => $dto->isVerified,
        'level' => $dto->level,
        'parent_id' => $dto->parentId
    ])->toArray();
    }

    public function getCommentsByPost(int $id): array
    {
        return Comment::with(['user.profile'])
            ->where('post_id', $id)
            ->orderBy('created_at')
            ->get()
            ->toArray();
    }

    public function update(array $comment): void
    {
        $commentModel = Comment::findOrFail($comment['id']);
        $commentModel->update($comment);
    }

    public function save(array $comment): array
    {
        return Comment::create($comment)->toArray();
    }

    public function getCommentsVerifiedCount(): int
    {
        return Comment::verified()->count();
    }

    public function getCommentsNotVerifiedCount(): int
    {
        return Comment::notVerified()->count();
    }

    public function getPaginatedComments(bool $isStart, ?int $id = null): LengthAwarePaginator
    {
        $query = Comment::with(['user.profile', 'post'])
            ->latest();

        return $isStart 
            ? $query->paginate(10)
            : $query->paginate(10, ['*'], 'page', $id);
    }

    public function getUnpublishedComments(): array
    {
        return Comment::with(['user.profile'])
            ->notVerified()
            ->latest()
            ->get()
            ->toArray();
    }
}
