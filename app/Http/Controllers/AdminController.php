<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function users()
    {
        return view('admin.users');
    }

    public function posts()
    {
        return view('admin.posts');
    }

    public function comments()
    {
        return view('admin.comments');
    }

    public function seo()
    {
        return view('admin.seo');
    }
}
