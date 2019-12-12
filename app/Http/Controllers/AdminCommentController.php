<?php

namespace App\Http\Controllers;

use App\Repositories\CachedCommentRepository;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    protected $commentRepository;


    public function __construct(CachedCommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function edit($id)
    {
        return view('admin.comment.edit');
    }

    public function publish(Request $request)
    {
        $id = $request->id;

        $this->commentRepository->publish($id);
    }
}
