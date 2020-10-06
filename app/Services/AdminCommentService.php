<?php

namespace App\Services;


use App\Repositories\CachedCommentRepository;

class AdminCommentService
{
    protected CachedCommentRepository $commentRepository;

    public function __construct(CachedCommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function publish($id): void
    {
        $comment = $this->commentRepository->getById($id);

        $comment = $this->changeVerifyComment($comment);

        $this->commentRepository->update($comment);
    }

    private function changeVerifyComment(array $comment)
    {
        if ($comment['is_verified']) {
            $comment['is_verified'] = 0;
        } else {
            $comment['is_verified'] = 1;
        }

        return $comment;
    }
}