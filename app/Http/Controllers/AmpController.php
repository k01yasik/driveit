<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommentService;
use App\Post;

class AmpController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function show($slug)
    {
        $post = Post::with(['user', 'categories', 'user.profile'])->where('slug', $slug)->firstOrFail();

        $seo = [
            "title" => $post->title,
            "description" => $post->description,
        ];

        $sortedComments = $this->commentService->sortComments($post->id);

        return view('amp.show', compact('seo', 'post', 'sortedComments'));
    }
}
