<?php

namespace App\Services;

use App\Comment;
use App\Repositories\CachedCommentRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CommentService
 *
 * @package App\Services
 */
class CommentService
{
    protected $commentRepository;

    public function __construct(CachedCommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param int $id
     * @return Collection
     */
    protected function getCommentsByPost(int $id): Collection
    {
        return Comment::with(['user', 'user.profile'])
            ->where('post_id', $id)
            ->orderBy('created_at')
            ->get();
    }

    /**
     * @param array $comments
     * @param $element
     * @return array
     */
    protected function addCommentToArray(array $comments, $element): array
    {
        return $comments[] = $element;
    }

    /**
     * @param $parent
     * @param $child
     * @param int $level
     * @return bool
     */
    protected function isChild($parent, $child, int $level): bool
    {
        return $child->level == $level && $child->parent_id == $parent->id;
    }

    public function sortComments($id)
    {
        $sortedComments = [];

        $comments = $this->getCommentsByPost($id);

        foreach ($comments as $comment) {
            $sortedComments = $this->addCommentToArray($sortedComments, $comment);

            foreach ($comments as $comment_1) {
                if ($this->isChild($comment, $comment_1, 1)) {
                    $sortedComments = $this->addCommentToArray($sortedComments, $comment_1);

                    foreach ($comments as $comment_2) {
                        if ($this->isChild($comment_1, $comment_2, 2)) {
                            $sortedComments = $this->addCommentToArray($sortedComments, $comment_2);

                            foreach ($comments as $comment_3) {
                                if ($this->isChild($comment_2, $comment_3, 3)) {
                                    $sortedComments = $this->addCommentToArray($sortedComments, $comment_3);

                                    foreach ($comments as $comment_4) {
                                        if ($this->isChild($comment_3, $comment_4, 4)) {
                                            $sortedComments = $this->addCommentToArray($sortedComments, $comment_4);
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
}
