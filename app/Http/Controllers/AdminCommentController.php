<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function edit($id)
    {
        return view('admin.comment.edit');
    }
}
