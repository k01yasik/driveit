<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function post2(Request $request)
    {
        if (Auth::guard('api')->check()) {
            return response()->json(User::find(4));
        } else {
            return response()->json(Post::find(119));
        }
    }
}
