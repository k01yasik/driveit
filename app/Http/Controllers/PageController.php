<?php

namespace App\Http\Controllers;

use App\Services\AdvertisementService;
use Illuminate\Http\Request;
use App\Services\SeoService;
use App\Services\CommentService;
use App\Services\PaginateService;
use App\Services\PostSortService;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    protected $seoService;
    protected $commentService;
    protected $paginateService;
    protected $postSortService;
    protected $advertisementService;

    public function __construct(SeoService $seoService, CommentService $commentService, PaginateService $paginateService, PostSortService $postSortService, AdvertisementService $advertisementService)
    {
        $this->seoService = $seoService;
        $this->commentService = $commentService;
        $this->paginateService = $paginateService;
        $this->postSortService = $postSortService;
        $this->advertisementService = $advertisementService;
    }

    public function home(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = Cache::rememberForever('latest-posts', function (){

            $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->orderByDesc('date_published')->take(10)->get();

            foreach ($posts as $post) {

                $post->rating_count = 0;
                $post->comments_count = 0;

                foreach ($post->rating as $r) {
                    if ($r->rating === 1) {
                        $post->rating_count = $post->rating_count + 1;
                    }
                }

                foreach ($post->comments as $c) {
                    if ($c->is_verified === 1) {
                        $post->comments_count = $post->comments_count + 1;
                    }
                }
            }

            return $posts;
        });

        $adverts = $this->advertisementService->getAds();

        debug($adverts);

        return view('page.home', compact('seo', 'posts', 'adverts'));
    }

    public function index(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = Cache::rememberForever('paginated-posts', function (){

            $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->orderByDesc('date_published')->paginate(10);

            foreach ($posts as $post) {

                $post->rating_count = 0;
                $post->comments_count = 0;

                foreach ($post->rating as $r) {
                    if ($r->rating === 1) {
                        $post->rating_count = $post->rating_count + 1;
                    }
                }

                foreach ($post->comments as $c) {
                    if ($c->is_verified === 1) {
                        $post->comments_count = $post->comments_count + 1;
                    }
                }
            }

            return $posts;
        });

        $previousNumberPage = $posts->currentPage() - 1;
        $nextNumberPage = $posts->currentPage() + 1;
        $lastNumberPage = $posts->lastPage();

        $adverts = $this->advertisementService->getAds();

        return view('posts.index', compact('seo', 'posts', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage', 'adverts'));
    }

    public function paginate($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->orderByDesc('date_published')->paginate(10, ['*'], 'page', $id);

        foreach ($posts as $post) {

            $post->rating_count = 0;
            $post->comments_count = 0;

            foreach ($post->rating as $r) {
                if ($r->rating === 1) {
                    $post->rating_count = $post->rating_count + 1;
                }
            }

            foreach ($post->comments as $c) {
                if ($c->is_verified === 1) {
                    $post->comments_count = $post->comments_count + 1;
                }
            }
        }


        $previousNumberPage = $posts->currentPage() - 1;
        $nextNumberPage = $posts->currentPage() + 1;
        $lastNumberPage = $posts->lastPage();

        $adverts = $this->advertisementService->getAds();

        return view('posts.index', compact('seo', 'posts', 'nextNumberPage', 'previousNumberPage', 'lastNumberPage', 'adverts'));
    }

    public function list(Request $request) {
        $seo = $this->seoService->getSeoData($request);
        $name = $request->route()->getName();

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->get();

        foreach ($posts as $post) {

            $post->rating_count = 0;
            $post->comments_count = 0;

            foreach ($post->rating as $r) {
                if ($r->rating === 1) {
                    $post->rating_count = $post->rating_count + 1;
                }
            }

            foreach ($post->comments as $c) {
                if ($c->is_verified === 1) {
                    $post->comments_count = $post->comments_count + 1;
                }
            }
        }

        $data = $this->paginateService->paginationData(10, 1, url()->current(), $posts->count());

        if ($name == 'posts.rated') {

            $posts = $this->postSortService->sortedBy($posts, 'posts.rated');

            $posts = $posts->slice( 0, $data['perPage']);

        } else if ($name == 'posts.views') {

            $posts = $this->postSortService->sortedBy($posts, 'posts.views');

            $posts = $posts->slice(0, $data['perPage']);

        } else {

            $posts = $this->postSortService->sortedBy($posts, 'posts.comments');

            $posts = $posts->slice(0, $data['perPage']);

        }

        $adverts = $this->advertisementService->getAds();

        return view('posts.list', compact('seo', 'posts', 'data', 'adverts'));
    }

    public function commentsPaginate($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->get();

        foreach ($posts as $post) {

            $post->rating_count = 0;
            $post->comments_count = 0;

            foreach ($post->rating as $r) {
                if ($r->rating === 1) {
                    $post->rating_count = $post->rating_count + 1;
                }
            }

            foreach ($post->comments as $c) {
                if ($c->is_verified === 1) {
                    $post->comments_count = $post->comments_count + 1;
                }
            }
        }

        $seo['title'] = $seo['title'].'. Страница - '.$id.'.';
        $seo['description'] = $seo['description'].'. Страница - '.$id.'.';

        $data = $this->paginateService->paginationData(10, $id, config('app.url').'/best-comments', $posts->count());

        $posts = $this->postSortService->sortedBy($posts, 'posts.comments');

        $posts = $posts->slice($data['perPage'] * $id - $data['perPage'], $data['perPage']);

        $adverts = $this->advertisementService->getAds();

        return view('posts.list', compact('seo', 'posts', 'data', 'adverts'));
    }

    public function ratedPaginate($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->get();

        foreach ($posts as $post) {

            $post->rating_count = 0;
            $post->comments_count = 0;

            foreach ($post->rating as $r) {
                if ($r->rating === 1) {
                    $post->rating_count = $post->rating_count + 1;
                }
            }

            foreach ($post->comments as $c) {
                if ($c->is_verified === 1) {
                    $post->comments_count = $post->comments_count + 1;
                }
            }
        }

        $seo['title'] = $seo['title'].'. Страница - '.$id.'.';
        $seo['description'] = $seo['description'].'. Страница - '.$id.'.';

        $data = $this->paginateService->paginationData(10, $id, config('app.url').'/best-rated', $posts->count());

        $posts = $this->postSortService->sortedBy($posts, 'posts.rated');

        $posts = $posts->slice($data['perPage'] * $id - $data['perPage'], $data['perPage']);

        $adverts = $this->advertisementService->getAds();

        return view('posts.list', compact('seo', 'posts', 'data', 'adverts'));
    }

    public function viewsPaginate($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->where('is_published', 1)->get();

        foreach ($posts as $post) {

            $post->rating_count = 0;
            $post->comments_count = 0;

            foreach ($post->rating as $r) {
                if ($r->rating === 1) {
                    $post->rating_count = $post->rating_count + 1;
                }
            }

            foreach ($post->comments as $c) {
                if ($c->is_verified === 1) {
                    $post->comments_count = $post->comments_count + 1;
                }
            }
        }

        $seo['title'] = $seo['title'].'. Страница - '.$id.'.';
        $seo['description'] = $seo['description'].'. Страница - '.$id.'.';

        $data = $this->paginateService->paginationData(10, $id, config('app.url').'/best-views', $posts->count());

        $posts = $this->postSortService->sortedBy($posts, 'posts.views');

        $posts = $posts->slice($data['perPage'] * $id - $data['perPage'], $data['perPage']);

        $adverts = $this->advertisementService->getAds();

        return view('posts.list', compact('seo', 'posts', 'data', 'adverts'));
    }

    public function about(Request $request) {
        $seo = $this->seoService->getSeoData($request);

        $adverts = $this->advertisementService->getAds();

        return view('page.about', compact('seo', 'adverts'));
    }

    public function rules(Request $request) {
        $seo = $this->seoService->getSeoData($request);

        $adverts = $this->advertisementService->getAds();

        return view('page.rules', compact('seo', 'adverts'));
    }

    public function show($slug)
    {

        $post = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments', 'suggest'])->where([['slug', $slug], ['is_published', 1]])->firstOrFail();

        $post->rating_count = 0;
        $post->comments_count = 0;

        foreach ($post->rating as $r) {
            if ($r->rating === 1) {
                $post->rating_count = $post->rating_count + 1;
            }
        }

        foreach ($post->comments as $c) {
            if ($c->is_verified === 1) {
                $post->comments_count = $post->comments_count + 1;
            }
        }


        $suggest_ids = [];

        foreach ($post->suggest as $suggest) {
            array_push($suggest_ids, $suggest->suggest);
        }

        $suggest_posts = Post::with(['user', 'categories', 'user.profile', 'rating', 'comments'])->find($suggest_ids);

        foreach ($suggest_posts as $pp) {

            $pp->rating_count = 0;
            $pp->comments_count = 0;

            foreach ($pp->rating as $r) {
                if ($r->rating === 1) {
                    $pp->rating_count = $pp->rating_count + 1;
                }
            }

            foreach ($pp->comments as $c) {
                if ($c->is_verified === 1) {
                    $pp->comments_count = $pp->comments_count + 1;
                }
            }
        }

        $post->increment('views');

        event('eloquent.saved: App\Post', $post);

        $seo = [
            "title" => $post->title,
            "description" => $post->description,
            "image" => $post->image_path,
            "type" => 'article'
        ];

        $authenticated = Auth::check();
        $sortedComments = $this->commentService->sortComments($post->id);

        $adverts = $this->advertisementService->getAds();

        return view('posts.show', compact('seo', 'post', 'sortedComments', 'authenticated', 'suggest_posts', 'adverts'));
    }
}