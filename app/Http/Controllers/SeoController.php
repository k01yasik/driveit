<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('seo.create');
    }

    public function show($id)
    {
        return view('seo.show');
    }

    public function edit($id)
    {
        return view('seo.edit');
    }
}
