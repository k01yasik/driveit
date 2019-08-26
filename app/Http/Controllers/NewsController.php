<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index() {
        return view('news.index');
    }

    public function create() {
        return view('news.create');
    }

    public function store() {

    }

    public function edit($id) {
        return view('news.create');
    }

    public function update($id) {

    }

    public function delete($id) {

    }

    public function publishToggle($id) {

    }
}
