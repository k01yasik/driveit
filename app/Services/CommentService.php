<?php

namespace App\Services;

use App\Comment;

class CommentService
{
    public function sortComments($id)
    {
        $sortedComments = [];

        $comments = Comment::with(['user', 'user.profile'])->where('post_id', $id)->orderBy('created_at')->get();

        foreach ($comments as $comment) {
            array_push($sortedComments, $comment);

            foreach($comments as $comment_1) {
                if ($comment_1->level == 1 && $comment_1->parent_id == $comment->id) {
                    array_push($sortedComments, $comment_1);

                    foreach($comments as $comment_2) {
                        if ($comment_2->level == 1 && $comment_2->parent_id == $comment_1->id) {
                            array_push($sortedComments, $comment_1);

                            foreach($comments as $comment_3) {
                                if ($comment_3->level == 1 && $comment_3->parent_id == $comment_2->id) {
                                    array_push($sortedComments, $comment_1);

                                    foreach($comments as $comment_4) {
                                        if ($comment_4->level == 1 && $comment_4->parent_id == $comment_4->id) {
                                            array_push($sortedComments, $comment_1);
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