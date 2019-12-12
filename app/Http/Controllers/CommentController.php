<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentStoreRequest;
use App\Repositories\CachedCommentRepository;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    protected $commentRepository;

    public function __construct(CachedCommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function edit($username, $id){
        return view('user.comment.edit');
    }

    public function store(CommentStoreRequest $request)
    {
        $data = $request->validated();

        return $this->commentRepository->store($data);
    }
}
