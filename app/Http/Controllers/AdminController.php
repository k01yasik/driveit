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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

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

        $posts = Cache::rememberForever('posts_count_cart', function () {
            return DB::table('posts')
                ->select(DB::raw('SQL_NO_CACHE YEAR(date_published) year, MONTH(date_published) month, COUNT(1) count'))
                ->where('is_published', true)
                ->groupBy(DB::raw('YEAR(date_published), MONTH(date_published)'))
                ->get();
        });

        $user_id = Auth::id();

        $user = Cache::rememberForever('user_with_profile_'.$user_id, function () use ($user_id) {
            return User::with('profile')->where('id', $user_id)->firstOrFail();
        });

        return view('admin.index', compact('seo', 'user', 'posts'));
    }

    public function users(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $user_id = Auth::id();

        $user = Cache::rememberForever('user_with_profile_'.$user_id, function () use ($user_id) {
            return User::with('profile')->where('id', $user_id)->firstOrFail();
        });

        $users = Cache::rememberForever('all-users', function () {
            return User::with('profile', 'rip')->get();
        });

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

        $user_id = Auth::id();

        $user = Cache::rememberForever('user_with_profile_'.$user_id, function () use ($user_id) {
            return User::with('profile')->where('id', $user_id)->firstOrFail();
        });

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

        $user = User::with('profile')->where('id', Auth::id())->firstOrFail();

        $comments = Comment::with(['user', 'user.profile', 'post'])->orderByDesc('created_at')->paginate(10);

        $unpublish_comments_count = Comment::where('is_verified', 0)->count();

        $previousNumberPage = $comments->currentPage() - 1;
        $nextNumberPage = $comments->currentPage() + 1;
        $lastNumberPage = $comments->lastPage();

        return view('admin.comments', compact('seo', 'comments', 'previousNumberPage', 'nextNumberPage', 'lastNumberPage', 'user', 'unpublish_comments_count'));
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

        $unpublish_comments_count = Comment::where('is_verified', 0)->count();

        $user = User::with('profile')->where('id', Auth::id())->firstOrFail();

        return view('admin.unpublished', compact('seo', 'comments', 'user', 'unpublish_comments_count'));
    }

    public function seo()
    {
        return view('admin.seo');
    }
}
