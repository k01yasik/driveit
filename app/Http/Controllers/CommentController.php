<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit($username, $id){
        return view('user.comment.edit');
    }

    public function adminedit($id)
    {
        return view('admin.comment.edit');
    }
}
