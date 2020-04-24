<?php

namespace App\Services;

use App\Comment;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CommentService
 *
 * @package App\Services
 */
class CommentService
{
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
                        if ($comment_2->level == 2
                            && $comment_2->parent_id == $comment_1->id
                        ) {
                            $sortedComments = $this->addCommentToArray($sortedComments, $comment_2);

                            foreach ($comments as $comment_3) {
                                if ($comment_3->level == 3
                                    && $comment_3->parent_id == $comment_2->id
                                ) {
                                    $sortedComments = $this->addCommentToArray($sortedComments, $comment_3);

                                    foreach ($comments as $comment_4) {
                                        if ($comment_4->level == 4
                                            && $comment_4->parent_id == $comment_4->id
                                        ) {
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
}
