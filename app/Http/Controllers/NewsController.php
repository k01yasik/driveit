<?php

namespace App\Http\Controllers;

use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected NewsService $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }


    public function index(Request $request) {
        $news = $this->newsService->getLastNews();

        return view('news.index', compact('news'));
    }

    public function store(Request $request) {

    }

    public function update(Request $request, $id) {

    }

    public function delete(Request $request, $id) {

    }

    public function publishToggle(Request $request, $id) {

    }
}
