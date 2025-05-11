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

    public function store(Request $request, int $postId): JsonResponse
    {
        $validated = $request->validate([...]);

        $dto = new CommentDTO(
            userId: auth()->id(),
            postId: $postId,
            message: $validated['message'],
            level: $validated['level'],
            parentId: $validated['parent'] ?? null
        );

        $result = $this->commentService->store($dto);
        
        return response()->json($result->toArray());
    }
}
