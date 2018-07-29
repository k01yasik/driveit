<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($username) {
        return view('user.homepage');
    }

    public function settings($username) {
        return view('user.settings');
    }

    public function friends($username) {
        return view('user.friends');
    }

    public function messages($username) {
        return view('user.messages');
    }

    public function friendMessages($username, $friend) {
        return view('user.friendmessages');
    }
}
