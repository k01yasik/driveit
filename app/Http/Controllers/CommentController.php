<?php

namespace App\Http\Controllers;

use App\DTO\CommentDTO;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{
    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function edit($username, $id)
    {
        return view('user.comment.edit');
    }

    public function store(Request $request, ?int $post = null): JsonResponse
    {
        $request->merge([
            'post' => $post ?? $request->input('post'),
            'parent_id' => $request->input('parent_id', $request->input('parent')),
        ]);

        $postId = (int) $request->input('post');
        $parentRules = ['nullable', 'integer', 'min:0'];
        if ($request->input('parent_id') != 0) {
            $parentRules[] = Rule::exists('comments', 'id')->where('post_id', $postId);
        }

        $validated = $request->validate([
            'post' => ['required', 'integer', 'exists:posts,id'],
            'message' => ['required', 'string', 'max:5000'],
            'level' => ['required', 'integer', 'min:0', 'max:5'],
            'parent_id' => $parentRules,
        ]);

        $parentId = (int) ($validated['parent_id'] ?? 0);
        $comment = new CommentDTO(
            userId: (int) $request->user()->id,
            postId: (int) $validated['post'],
            message: $validated['message'],
            level: (int) $validated['level'],
            parentId: $parentId ?: null
        );

        $result = $this->commentService->store($comment);

        return response()->json([
            'level' => $result->level,
            'username' => $result->username,
            'avatar' => $result->avatar,
            'url' => $result->url,
            'created_at' => $result->createdAt,
            'message' => $result->message,
        ]);
    }
}
