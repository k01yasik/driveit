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


    public function index() {
        $news = $this->newsService->getLastNews();

        return view('news.index', compact('news'));
    }

    public function store() {

    }

    public function update($id) {

    }

    public function delete($id) {

    }

    public function publishToggle($id) {

    }
}
