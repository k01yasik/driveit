<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class AdminCommentController extends Controller
{
    public function edit($id)
    {
        return view('admin.comment.edit');
    }

    public function publish(Request $request)
    {
        $id = $request->id;

        $comment = Comment::find($id);

        if ($comment->is_verified) {
            $comment->is_verified = 0;
        } else {
            $comment->is_verified = 1;
        }

        $comment->save();
    }
}
