<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Services\CommentService;


class CommentController extends Controller
{
    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function edit($username, $id){
        return view('user.comment.edit');
    }

    public function store(CommentStoreRequest $request)
    {
        $data = $request->validated();

        return $this->commentService->store($data);
    }
}
