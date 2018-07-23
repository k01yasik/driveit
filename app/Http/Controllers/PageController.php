<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home() {
        $title = 'Сайт о ремонте и уходе за автомобилями и мотоциклами';
        $route_name = 'home';
        return view('welcome', compact('title'));
    }
}
