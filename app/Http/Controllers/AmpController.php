<?php

namespace App\Http\Controllers;

use App\Repositories\CachedPostRepository;
use App\Services\CommentService;

class AmpController extends Controller
{
    protected CommentService $commentService;
    protected CachedPostRepository $postRepository;

    public function __construct(CommentService $commentService, CachedPostRepository $postRepository)
    {
        $this->commentService = $commentService;
        $this->postRepository = $postRepository;
    }

    public function show($slug)
    {
        $post = $this->postRepository->getPostBySlugWithUserData($slug);

        $seo = [
            "title" => $post['title'],
            "description" => $post['description'],
        ];

        $sortedComments = $this->commentService->sortComments($post['id']);

        return view('amp.show', compact('seo', 'post', 'sortedComments'));
    }
}
