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
        return view('users.homepage');
    }

    public function settings($username) {
        return view('users.settings');
    }

    public function friends($username) {
        return view('users.friends');
    }

    public function messages($username) {
        return view('users.messages');
    }

    public function friendMessages($username, $friend) {
        return view('users.friendmessages');
    }
}