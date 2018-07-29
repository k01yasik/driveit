<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAlbumsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($username) {
        return view('user.albums.index');
    }

    public function create($username) {
        return view('user.albums.create');
    }

    public function show($username, $albumname) {
        return view('user.albums.show');
    }

    public function edit($username, $albumname) {
        return view('user.albums.edit');
    }
}
