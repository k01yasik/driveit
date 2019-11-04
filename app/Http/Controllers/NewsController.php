<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\NewsRepositoryInterface;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $news;

    /**
     * NewsController constructor.
     * @param $news
     */
    public function __construct(NewsRepositoryInterface $news)
    {
        $this->news = $news;
    }


    public function index() {
        $news = $this->news->getLastNews();

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
