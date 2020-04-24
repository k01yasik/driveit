<?php

namespace App\Http\Controllers;

use App\Services\AdminCommentService;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    protected $commentService;

    public function __construct(AdminCommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function edit($id)
    {
        return view('admin.comment.edit');
    }

    public function publish(Request $request)
    {
        $id = $request->id;

        $this->commentService->publish($id);
    }
}
