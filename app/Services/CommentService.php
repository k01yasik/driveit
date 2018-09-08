<?php

namespace App\Services;

use App\Comment;

class CommentService
{
    public function sortComments($id)
    {
        $sortedComments = [];

        $comments = Comment::with(['user', 'user.profile'])->where([['post_id', $id], ['is_verified', 1], ['level', 0]])->get();

        foreach ($comments as $comment) {
            array_push($sortedComments, $comment);

            $comments_2 = Comment::with(['user', 'user.profile'])->where([['post_id', $id], ['is_verified', 1], ['level', 1], ['parent_id', $comment->id]])->get();

            foreach ($comments_2 as $comment_2) {
                array_push($sortedComments, $comment_2);

                $comments_3 = Comment::with(['user', 'user.profile'])->where([['post_id', $id], ['is_verified', 1], ['level', 2], ['parent_id', $comment_2->id]])->get();

                foreach ($comments_3 as $comment_3) {
                    array_push($sortedComments, $comment_3);

                    $comments_4 = Comment::with(['user', 'user.profile'])->where([['post_id', $id], ['is_verified', 1], ['level', 3], ['parent_id', $comment_3->id]])->get();

                    foreach ($comments_4 as $comment_4) {
                        array_push($sortedComments, $comment_4);
                    }
                }
            }
        }

        return $sortedComments;
    }
}