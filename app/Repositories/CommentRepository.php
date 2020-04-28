<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;

class CommentRepository implements CommentRepositoryInterface
{

    public function publish(int $id): void
    {
        $comment = Comment::find($id);

        if ($comment->is_verified) {
            $comment->is_verified = 0;
        } else {
            $comment->is_verified = 1;
        }

        $comment->save();
    }

    public function getCommentsVerifiedCount(): int
    {
        return Comment::verified()->count();
    }

    public function getCommentsNotVerifiedCount(): int
    {
        return Comment::notVerified()->count();
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

    public function store(array $data): array
    {
        $user = Auth::user();

        $comment = new Comment;
        $comment->user()->associate($user);
        $comment->post_id = $data['post'];
        $comment->message = clean($data['message']);
        $comment->is_verified = 0;
        $comment->level = $data['level'];

        if ($data['parent'] > 0) {
            $comment->parent_id = $data['parent'];
        }

        $comment->save();

        return [
            'level' => $comment->level,
            'username' => $user->username,
            'avatar' => $user->profile()->first()->avatar,
            'url' => route('user.profile', ['username' => $user->username]),
            'created_at' => $comment->created_at,
            'message' => __('Comment was sent for moderation.'),
        ];
    }

    public function getUnpublishedComments(): Collection
    {
        return Comment::with(['user', 'user.profile'])->where('is_verified', 0)->orderByDesc('created_at')->get();
    }
}