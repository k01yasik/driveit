<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home(Request $request) {

        $title = 'Сайт о ремонте и уходе за автомобилями и мотоциклами';
        $route_name = $request->route()->getName();
        return view('page.home', compact('title', 'route_name'));
    }

    public function list() {
        $title = 'Сайт о ремонте и уходе за автомобилями и мотоциклами';
        return view('posts.list', compact('title'));
    }

    public function about() {
        return view('page.about');
    }

    public function rules() {
        $title = 'Сайт о ремонте и уходе за автомобилями и мотоциклами';
        return view('page.rules', compact('title'));
    }

    public function post($slug)
    {
        return view('posts.show');
    }
}
