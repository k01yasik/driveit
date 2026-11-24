<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentUpdateRequest;
use App\Services\AdminCommentService;
use App\Services\CommentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    protected AdminCommentService $commentService;

    public function __construct(AdminCommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function edit(Comment $comment): View
    {
        Gate::authorize('moderate', $comment);

        return view('admin.comment.edit', [
            'comment' => $comment,
            'action' => route('admin.comment.update', $comment),
            'back' => route('admin.comments'),
        ]);
    }

    public function update(CommentUpdateRequest $request, Comment $comment, CommentService $comments): RedirectResponse
    {
        $changed = $comments->editMessage($comment, $request->validated('message'));

        return redirect()->route('admin.comments')
            ->with('comment_status', $changed ? __('Comment was sent for moderation.') : __('No changes to the comment.'));
    }

    public function publish(Request $request)
    {
        $validated = $request->validate(['id' => ['required', 'integer', 'min:1']]);

        $this->commentService->publish((int) $validated['id']);
    }
}
