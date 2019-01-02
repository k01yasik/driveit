<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\SeoService;
use App\Post;
use App\User;
use App\Comment;
use App\Rip;
use Illuminate\Support\Facades\Auth;

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

        /*$posts_count = Post::all()->count();
        $users_count = User::all()->count();
        $comments_count = Comment::all()->count();
        $seo_count = Seo::all()->count();*/

        $user = User::with('profile')->where('id', Auth::id())->firstOrFail();

        return view('admin.index', compact('seo', 'user'));
    }

    public function users(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $user = User::with('profile')->where('id', Auth::id())->firstOrFail();

        $users = User::with('profile', 'rip')->get();

        debug($users);

        return view('admin.users', compact('seo', 'user', 'users'));
    }

    public function show(Request $request, $username)
    {
        $user = User::with('profile', 'rip')->where('username', $username)->firstOrFail();

        $seo = [
            'title' => 'Информация о пользователе '.$user->username,
            'description' => 'Информация о пользователе '.$user->username
        ];

        return view('admin.user.show', compact('seo', 'user'));
    }

    public function delete(Request $request, $username)
    {
        $user = User::with('profile')->where('username', $username)->firstOrFail();

        $seo = [
            'title' => 'Удаление пользователя '.$user->username,
            'description' => 'Удаление пользователя '.$user->username
        ];

        return view('admin.user.delete', compact('seo', 'user'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function posts(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $user = User::with('profile')->where('id', Auth::id())->firstOrFail();

        $posts = Post::orderByDesc('id')->paginate(10);

        $previousNumberPage = $posts->currentPage() - 1;
        $nextNumberPage = $posts->currentPage() + 1;
        $lastNumberPage = $posts->lastPage();

        return view('admin.posts', compact('seo', 'user', 'posts', 'previousNumberPage', 'nextNumberPage', 'lastNumberPage'));
    }

    public function paginate(Request $request, $id)
    {
        $seo = [
            "title" => "Все статьи. Страница - ".$id.".",
            "description" => "Все статьи. Страница - ".$id.".",
        ];

        $user = User::with('profile')->where('id', Auth::id())->firstOrFail();

        $posts = Post::orderByDesc('id')->paginate(10, ['*'], 'page', $id);

        $previousNumberPage = $posts->currentPage() - 1;
        $nextNumberPage = $posts->currentPage() + 1;
        $lastNumberPage = $posts->lastPage();

        return view('admin.posts', compact('seo', 'user', 'posts', 'previousNumberPage', 'nextNumberPage', 'lastNumberPage'));
    }

    public function comments(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $comments = Comment::with(['user', 'user.profile'])->orderByDesc('created_at')->paginate(10);

        $previousNumberPage = $comments->currentPage() - 1;
        $nextNumberPage = $comments->currentPage() + 1;
        $lastNumberPage = $comments->lastPage();

        return view('admin.comments', compact('seo', 'comments', 'previousNumberPage', 'nextNumberPage', 'lastNumberPage'));
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

        return view('admin.comments', compact('seo', 'comments', 'previousNumberPage', 'nextNumberPage', 'lastNumberPage'));
    }

    public function unpublished(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $comments = Comment::with(['user', 'user.profile'])->where('is_verified', 0)->orderByDesc('created_at')->get();

        return view('admin.unpublished', compact('seo', 'comments'));
    }

    public function seo()
    {
        return view('admin.seo');
    }
}
