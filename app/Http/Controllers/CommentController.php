<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentStoreRequest;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function edit($username, $id){
        return view('user.comment.edit');
    }

    public function store(CommentStoreRequest $request)
    {
        $data = $request->validated();
        $current_user = Auth::user();

        $comment = new Comment;
        $comment->user()->associate($current_user);
        $comment->post_id = $data['post'];
        $comment->message = $data['message'];
        $comment->is_verified = 0;
        $comment->level = $data['level'];

        if ($data['parent'] > 0) {
            $comment->parent_id = $data['parent'];
        }

        $comment->save();

        return [
            'level' => $comment->level,
            'username' => $current_user->username,
            'avatar' => $current_user->profile()->first()->avatar,
            'url' => route('user.profile', ['username' => $current_user->username]),
            'created_at' => $comment->created_at,
            'message' => __('Comment was sent for moderation.'),
        ];
    }
}
