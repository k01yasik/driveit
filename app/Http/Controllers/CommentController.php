<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function edit($username, $id){
        return view('user.comment.edit');
    }
}
