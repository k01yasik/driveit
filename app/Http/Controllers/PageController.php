<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SeoService;
use App\Services\CommentService;
use App\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class PageController extends Controller
{
    protected $seoService;
    protected $commentService;

    public function __construct(SeoService $seoService, CommentService $commentService)
    {
        $this->seoService = $seoService;
        $this->commentService = $commentService;
    }

    public function home(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);
        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->orderByDesc('date_published')->take(10)->get();

        return view('page.home', compact('seo', 'posts'));
    }

    public function index(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->orderByDesc('date_published')->paginate(10);

        $previousNumberPage = $posts->currentPage() - 1;
        $nextNumberPage = $posts->currentPage() + 1;
        $lastNumberPage = $posts->lastPage();

        return view('posts.index', compact('seo', 'posts', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage'));
    }

    public function paginate($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->orderByDesc('date_published')->paginate(10, ['*'], 'page', $id);

        $previousNumberPage = $posts->currentPage() - 1;
        $nextNumberPage = $posts->currentPage() + 1;
        $lastNumberPage = $posts->lastPage();

        return view('posts.index', compact('seo', 'posts', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage'));
    }

    public function list(Request $request) {
        $seo = $this->seoService->getSeoData($request);
        $name = $request->route()->getName();

        $perPage = 10;
        $currentPage = 1;
        $currentUrl = url()->current();

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->get();

        $lastNumberPage = max((int) ceil($posts->count() / $perPage), 1);

        $previousNumberPage = $currentPage - 1;
        $nextNumberPage = $currentPage + 1;

        $hasPages = $currentPage != 1 || $currentPage < $lastNumberPage;
        $hasMorePages = $currentPage < $lastNumberPage;

        if ($name == 'posts.rated') {

            foreach ($posts as $post) {
                $post->setAttribute('rat', $post->rating->count());
                $post->setAttribute('seconds', strtotime($post->getOriginal('date_published')));
            }

            $posts = $posts->values()->all();

            array_multisort(array_column($posts, 'rat'), SORT_DESC, array_column($posts, 'seconds'), SORT_DESC, $posts);

            $posts = collect($posts);

            $posts = $posts->slice( 0, $perPage);

        } else if ($name == 'posts.views') {

            foreach ($posts as $post) {
                $post->setAttribute('seconds', strtotime($post->getOriginal('date_published')));
            }

            $posts = $posts->values()->all();

            array_multisort(array_column($posts, 'views'), SORT_DESC, array_column($posts, 'seconds'), SORT_DESC, $posts);

            $posts = collect($posts);

            $posts = $posts->slice(0, $perPage);

        } else {

            foreach ($posts as $post) {
                $post->setAttribute('comment', $post->comments->count());
                $post->setAttribute('seconds', strtotime($post->getOriginal('date_published')));
            }

            $posts = $posts->values()->all();

            array_multisort(array_column($posts, 'comment'), SORT_DESC, array_column($posts, 'seconds'), SORT_DESC, $posts);

            $posts = collect($posts);

            $posts = $posts->slice(0, $perPage);

        }



        return view('posts.list', compact('seo', 'posts', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage', 'hasPages', 'hasMorePages', 'currentPage', 'currentUrl'));
    }

    public function commentsPaginate($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].'. Страница - '.$id.'.';
        $seo['description'] = $seo['description'].'. Страница - '.$id.'.';

        $perPage = 10;
        $currentPage = $id;
        $currentUrl = config('app.url').'/best-comments';

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->get();

        $lastNumberPage = max((int) ceil($posts->count() / $perPage), 1);

        $previousNumberPage = $currentPage - 1;
        $nextNumberPage = $currentPage + 1;

        $hasPages = $currentPage != 1 || $currentPage < $lastNumberPage;
        $hasMorePages = $currentPage < $lastNumberPage;

        foreach ($posts as $post) {
            $post->setAttribute('comment', $post->comments->count());
            $post->setAttribute('seconds', strtotime($post->getOriginal('date_published')));
        }

        $posts = $posts->values()->all();

        array_multisort(array_column($posts, 'comment'), SORT_DESC, array_column($posts, 'seconds'), SORT_DESC, $posts);

        $posts = collect($posts);

        $posts = $posts->slice($perPage * $id - $perPage, $perPage);

        return view('posts.list', compact('seo', 'posts', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage', 'hasPages', 'hasMorePages', 'currentPage', 'currentUrl'));
    }

    public function ratedPaginate($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].'. Страница - '.$id.'.';
        $seo['description'] = $seo['description'].'. Страница - '.$id.'.';

        $perPage = 10;
        $currentPage = $id;
        $currentUrl = config('app.url').'/best-rated';

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->orderByDesc('date_published')->get();

        $lastNumberPage = max((int) ceil($posts->count() / $perPage), 1);

        $previousNumberPage = $currentPage - 1;
        $nextNumberPage = $currentPage + 1;

        $hasPages = $currentPage != 1 || $currentPage < $lastNumberPage;
        $hasMorePages = $currentPage < $lastNumberPage;

        foreach ($posts as $post) {
            $post->setAttribute('rat', $post->rating->count());
            $post->setAttribute('seconds', strtotime($post->getOriginal('date_published')));
        }

        $posts = $posts->values()->all();

        array_multisort(array_column($posts, 'rat'), SORT_DESC, array_column($posts, 'seconds'), SORT_DESC, $posts);

        $posts = collect($posts);

        $posts = $posts->slice($perPage * $id - $perPage, $perPage);

        return view('posts.list', compact('seo', 'posts', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage', 'hasPages', 'hasMorePages', 'currentPage', 'currentUrl'));
    }

    public function viewsPaginate($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].'. Страница - '.$id.'.';
        $seo['description'] = $seo['description'].'. Страница - '.$id.'.';

        $perPage = 10;
        $currentPage = $id;
        $currentUrl = config('app.url').'/best-views';

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->get();

        $lastNumberPage = max((int) ceil($posts->count() / $perPage), 1);

        $previousNumberPage = $currentPage - 1;
        $nextNumberPage = $currentPage + 1;

        $hasPages = $currentPage != 1 || $currentPage < $lastNumberPage;
        $hasMorePages = $currentPage < $lastNumberPage;

        foreach ($posts as $post) {
            $post->setAttribute('seconds', strtotime($post->getOriginal('date_published')));
        }

        $posts = $posts->values()->all();

        array_multisort(array_column($posts, 'views'), SORT_DESC, array_column($posts, 'seconds'), SORT_DESC, $posts);

        $posts = collect($posts);

        $posts = $posts->slice($perPage * $id - $perPage, $perPage);

        return view('posts.list', compact('seo', 'posts', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage', 'hasPages', 'hasMorePages', 'currentPage', 'currentUrl'));
    }

    public function about(Request $request) {
        $seo = $this->seoService->getSeoData($request);
        return view('page.about', compact('seo'));
    }

    public function rules(Request $request) {
        $seo = $this->seoService->getSeoData($request);
        return view('page.rules', compact('seo'));
    }

    public function show($slug)
    {
        $post = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where([['slug', $slug], ['is_published', 1]])->firstOrFail();

        $post->increment('views');

        $seo = [
            "title" => $post->title,
            "description" => $post->description,
            "image" => $post->image_path,
            "type" => 'article'
        ];

        $sortedComments = $this->commentService->sortComments($post->id);

        return view('posts.show', compact('seo', 'post', 'sortedComments'));
    }
}