<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SeoService;
use App\Post;
use App\User;
use App\Comment;
use App\Seo;

class AdminController extends Controller
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function index(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts_count = Post::all()->count();
        $users_count = User::all()->count();
        $comments_count = Comment::all()->count();
        $seo_count = Seo::all()->count();

        return view('admin.index', compact('seo', 'posts_count', 'users_count', 'comments_count', 'seo_count'));
    }

    public function users()
    {
        return view('admin.users');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function posts(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = Post::orderByDesc('id')->paginate(10);

        $previousNumberPage = $posts->currentPage() - 1;
        $nextNumberPage = $posts->currentPage() + 1;
        $lastNumberPage = $posts->lastPage();

        return view('admin.posts', compact('seo', 'posts', 'previousNumberPage', 'nextNumberPage', 'lastNumberPage'));
    }

    public function paginate(Request $request, $id)
    {
        $seo = [
            "title" => "Все статьи. Страница - ".$id.".",
            "description" => "Все статьи. Страница - ".$id.".",
        ];

        $posts = Post::orderByDesc('id')->paginate(10, ['*'], 'page', $id);

        $previousNumberPage = $posts->currentPage() - 1;
        $nextNumberPage = $posts->currentPage() + 1;
        $lastNumberPage = $posts->lastPage();

        return view('admin.posts', compact('seo', 'posts', 'previousNumberPage', 'nextNumberPage', 'lastNumberPage'));
    }

    public function comments(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $comments = Comment::with(['user', 'user.profile'])->orderByDesc('created_at')->paginate(10);

        $previousNumberPage = $comments->currentPage() - 1;
        $nextNumberPage = $comments->currentPage() + 1;
        $lastNumberPage = $comments->lastPage();

        $posts_count = Post::all()->count();
        $users_count = User::all()->count();
        $comments_count = Comment::all()->count();
        $seo_count = Seo::all()->count();

        return view('admin.comments', compact('seo', 'comments', 'previousNumberPage', 'nextNumberPage', 'lastNumberPage', 'posts_count', 'users_count', 'comments_count', 'seo_count'));
    }

    public function commentsPaginate(Request $request, $id)
    {

        $seo = [
            "title" => "Все комментарии. Страница - ".$id.".",
            "description" => "Все комментарии. Страница - ".$id.".",
        ];

        $comments = Comment::with(['user', 'user.profile'])->orderByDesc('created_at')->paginate(10, ['*'], 'page', $id);

        $previousNumberPage = $comments->currentPage() - 1;
        $nextNumberPage = $comments->currentPage() + 1;
        $lastNumberPage = $comments->lastPage();

        $posts_count = Post::all()->count();
        $users_count = User::all()->count();
        $comments_count = Comment::all()->count();
        $seo_count = Seo::all()->count();

        return view('admin.comments', compact('seo', 'comments', 'previousNumberPage', 'nextNumberPage', 'lastNumberPage', 'posts_count', 'users_count', 'comments_count', 'seo_count'));
    }

    public function unpublished(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $comments = Comment::with(['user', 'user.profile'])->where('is_verified', 0)->orderByDesc('created_at')->get();

        $posts_count = Post::all()->count();
        $users_count = User::all()->count();
        $comments_count = Comment::all()->count();
        $seo_count = Seo::all()->count();

        debug($comments);

        return view('admin.unpublished', compact('seo', 'comments', 'posts_count', 'users_count', 'comments_count', 'seo_count'));
    }

    public function seo()
    {
        return view('admin.seo');
    }
}
