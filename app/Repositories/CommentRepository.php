<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;

class CommentRepository implements CommentRepositoryInterface
{

    /**
     * @param int $id
     * @return array
     */
    public function getById(int $id): array
    {
        return Comment::find($id)->toArray();
    }

    public function getCommentsByPost(int $id): array
    {
        return Comment::with(['user', 'user.profile'])
            ->where('post_id', $id)
            ->orderBy('created_at')
            ->get()->toArray();
    }

    public function update(array $comment): void
    {
        Comment::find($comment['id'])->update(
            [
                'user_id'       => $comment['user_id'],
                'post_id'       => $comment['post_id'],
                'message'       => $comment['message'],
                'is_verified'   => $comment['is_verified'],
                'level'         => $comment['level'],
                'parent_id'     => $comment['parent_id'],
            ]
        );
    }

    public function save(array $comment): array
    {
        $commentModel = new Comment;
        $commentModel->user_id = $comment['user_id'];
        $commentModel->post_id = $comment['post_id'];
        $commentModel->message = $comment['message'];
        $commentModel->is_verified = $comment['is_verified'];
        $commentModel->level = $comment['level'];
        $commentModel->parent_id = $comment['parent_id'];
        $commentModel->save();
        return $commentModel->toArray();
    }

    public function getCommentsVerifiedCount(): int
    {
        return Comment::where('is_verified', true)->count();
    }

    public function getCommentsNotVerifiedCount(): int
    {
        return Comment::where('is_verified', false)->count();
    }

    /**
     * @param bool $isStart
     * @param int|null $id
     * @return Paginator
     */
    public function getPaginatedComments(bool $isStart, int $id = null): Paginator
    {
        $comments = Comment::with(['user', 'user.profile', 'post'])->orderByDesc('created_at');

        if ($isStart) {
            return $comments->paginate(10);
        }

        return $comments->paginate(10, ['*'], 'page', $id);
    }

    public function getUnpublishedComments(): array
    {
        return Comment::with(['user', 'user.profile'])->where('is_verified', 0)->orderByDesc('created_at')->get()->toArray();
    }
}