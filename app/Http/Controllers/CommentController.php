<?php

namespace App\Http\Controllers;

use App\Comment;
use App\DTO\CommentDTO;
use App\Http\Requests\CommentUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
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

    public function edit(string $username, Comment $comment): View
    {
        Gate::authorize('update', $comment);

        return view('user.comment.edit', [
            'comment' => $comment,
            'action' => route('user.comment.update', [$username, $comment]),
            'back' => route('posts.show', $comment->post->slug).'#comment-'.$comment->id,
            'seo' => ['title' => __('Edit comment'), 'description' => ''],
        ]);
    }

    public function update(CommentUpdateRequest $request, string $username, Comment $comment): RedirectResponse
    {
        $changed = $this->commentService->editMessage($comment, $request->validated('message'));

        return redirect(route('posts.show', $comment->post->slug).'#comment-'.$comment->id)
            ->with('comment_status', $changed ? __('Comment was sent for moderation.') : __('No changes to the comment.'));
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
