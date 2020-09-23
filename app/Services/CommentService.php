<?php

namespace App\Services;

use App\Comment;
use App\Repositories\CachedCommentRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Class CommentService
 *
 * @package App\Services
 */
class CommentService
{
    protected CachedCommentRepository $commentRepository;

    public function __construct(CachedCommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    protected function getCommentsByPost(int $id): array
    {
        return $this->commentRepository->getCommentsByPost($id);
    }

    /**
     * @param array $comments
     * @param $element
     * @return array
     */
    protected function addComment(array $comments, $element): array
    {
        array_push($comments, $element);

        return $comments;
    }

    /**
     * @param $parent
     * @param $child
     * @param int $level
     * @return bool
     */
    protected function isChild(array $parent, array $child, int $level): bool
    {
        return $child['level'] == $level && $child['parent_id'] == $parent['id'];
    }

    public function sortComments(int $id)
    {
        $sortedComments = [];

        $comments = $this->getCommentsByPost($id);

        foreach ($comments as $comment) {
            $sortedComments[] = $comment;

            foreach ($comments as $comment_1) {
                if ($this->isChild($comment, $comment_1, 1)) {
                    $sortedComments[] = $comment_1;

                    foreach ($comments as $comment_2) {
                        if ($this->isChild($comment_1, $comment_2, 2)) {
                            $sortedComments[] = $comment_2;

                            foreach ($comments as $comment_3) {
                                if ($this->isChild($comment_2, $comment_3, 3)) {
                                    $sortedComments[] = $comment_3;

                                    foreach ($comments as $comment_4) {
                                        if ($this->isChild($comment_3, $comment_4, 4)) {
                                            $sortedComments[] = $comment_4;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $sortedComments;
    }

    public function getUnpublishedComments()
    {
        return $this->commentRepository->getUnpublishedComments();
    }

    public function getCommentsVerifiedCount(): int
    {
        return $this->commentRepository->getCommentsVerifiedCount();
    }

    public function getCommentsNotVerifiedCount(): int
    {
        return $this->commentRepository->getCommentsNotVerifiedCount();
    }

    public function getPaginatedComments(bool $isStart, int $id = null): Paginator
    {
        return $this->commentRepository->getPaginatedComments($isStart, $id);
    }

    public function store(array $data): array
    {
        $user = Auth::user();

        $comment['user_id'] = $user->id;
        $comment['post_id'] = $data['post'];
        $comment['message'] = clean($data['message']);
        $comment['is_verified'] = 0;
        $comment['level'] = $data['level'];

        if ($data['parent'] > 0) {
            $comment['parent_id']= $data['parent'];
        }

        if ($savedComment = $this->commentRepository->save($comment)) {
            return [
                'level' => $savedComment['level'],
                'username' => $user->username,
                'avatar' => $user->profile()->first()->avatar,
                'url' => route('user.profile', ['username' => $user->username]),
                'created_at' => $savedComment['created_at'],
                'message' => __('Comment was sent for moderation.'),
            ];
        };

        return [];
    }
}
