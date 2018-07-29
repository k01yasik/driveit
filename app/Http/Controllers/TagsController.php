<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function show($tag) {
        return view('tags.show');
    }
}
