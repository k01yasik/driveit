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
        $validated = $request->validate([
            'message' => [
                'required',
                'string',
                'max:5000',
                function ($attribute, $value, $fail) {
                    if (strip_tags($value) !== $value) {
                        $fail('The '.$attribute.' contains disallowed HTML tags.');
                    }
                }
            ],
            'level' => 'required|integer|min:0|max:5',
            'parent_id' => [
                'nullable',
                'integer',
                'exists:comments,id',
                function ($attribute, $value, $fail) use ($postId) {
                    if ($value && !$this->commentService->isParentValid($value, $postId)) {
                        $fail('Invalid parent comment');
                    }
                }
            ]
        ]);

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
