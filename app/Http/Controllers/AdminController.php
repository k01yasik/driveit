<?php

namespace App\Http\Controllers;

use App\Repositories\CachedCommentRepository;
use App\Repositories\CachedPostDashboardRepository;
use App\Repositories\CachedPostRepository;
use App\Services\CommentService;
use App\Services\GoogleAnalyticsService;
use App\Services\PaginatorService;
use App\Services\PostDashboardService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Services\SeoService;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected $seoService;
    protected $userService;
    protected PostDashboardService $postDashboardService;
    protected $commentService;
    protected $googleAnalyticsService;
    protected $postRepository;
    protected $paginatorService;

    public function __construct(SeoService $seoService,
                                UserService $userService,
                                PostDashboardService $postDashboardService,
                                CommentService $commentService,
                                GoogleAnalyticsService $googleAnalyticsService,
                                CachedPostRepository $postRepository,
                                PaginatorService $paginatorService)
    {
        $this->seoService = $seoService;
        $this->userService = $userService;
        $this->postDashboardService = $postDashboardService;
        $this->commentService = $commentService;
        $this->googleAnalyticsService = $googleAnalyticsService;
        $this->postRepository = $postRepository;
        $this->paginatorService = $paginatorService;
    }

    public function index(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $posts = $this->postDashboardService->getPostDashboard();

        $commentsVerified = $this->commentService->getCommentsVerifiedCount();

        $commentsNotVerified = $this->commentService->getCommentsNotVerifiedCount();

        $commentsAll = $commentsVerified + $commentsNotVerified;

        $analyticData = $this->googleAnalyticsService->getAnalyticData();

        $datesQuery = $analyticData[0];
        $usersQuery = $analyticData[1];
        $sessionQuery = $analyticData[2];
        $hitsQuery = $analyticData[3];

        $countryData = $this->googleAnalyticsService->getAnalyticCountryData();

        $countryQueryLabels = $countryData[0];
        $countryQueryData = $countryData[1];

        $cityData = $this->googleAnalyticsService->getCityByCountry('Russia');

        $cityQueryLabels = $cityData[0];
        $cityQueryData = $cityData[1];

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        $activeItem = $this->seoService->getRouteName($request);

        return view('admin.index', compact('seo', 'user', 'posts', 'commentsVerified',
            'commentsNotVerified', 'commentsAll', 'datesQuery', 'usersQuery', 'sessionQuery', 'hitsQuery',
            'countryQueryData', 'countryQueryLabels', 'cityQueryLabels', 'cityQueryData', 'activeItem'));
    }

    public function users(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        $users = $this->userService->getAllUsers();

        $activeItem = $this->seoService->getRouteName($request);

        return view('admin.users', compact('seo', 'user', 'users', 'activeItem'));
    }

    public function verified(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        $users = $this->userService->getVerifiedUsers();

        $activeItem = $this->seoService->getRouteName($request);

        return view('admin.users', compact('seo', 'user', 'users', 'activeItem'));
    }

    public function unverified(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        $users = $this->userService->getUnverifiedUsers();

        $activeItem = $this->seoService->getRouteName($request);

        return view('admin.users', compact('seo', 'user', 'users', 'activeItem'));
    }

    public function banned(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        $users = $this->userService->getBannedUsers();

        $activeItem = $this->seoService->getRouteName($request);

        return view('admin.users', compact('seo', 'user', 'users', 'activeItem'));
    }

    public function show(Request $request, $username)
    {
        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        $data = $this->userService->getUserByUsername($username);

        $seo = [
            'title' => 'Информация о пользователе '.$data->username,
            'description' => 'Информация о пользователе '.$data->username
        ];

        return view('admin.user.show', compact('seo', 'user', 'data'));
    }

    public function delete(Request $request, $username)
    {
        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        $data = $this->userService->getUserByUsername($username);

        $seo = [
            'title' => 'Удаление пользователя '.$data->username,
            'description' => 'Удаление пользователя '.$data->username
        ];

        return view('admin.user.delete', compact('seo', 'user', 'data'));
    }

    public function posts(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        $posts = $this->postRepository->getPaginatedPostsOrderedById(true);

        $pages = $this->paginatorService->calculatePages($posts);

        $previousNumberPage = $pages["previousPage"];
        $nextNumberPage = $pages["nextPage"];
        $lastNumberPage = $pages["lastPage"];

        $items = $posts;
        $items_to_display = 3;
        $paginated_route = '/admin/posts';

        $activeItem = $this->seoService->getRouteName($request);

        return view('admin.posts', compact('seo', 'user', 'posts', 'previousNumberPage',
            'nextNumberPage', 'lastNumberPage', 'items', 'paginated_route', 'items_to_display', 'activeItem'));
    }

    public function paginate(Request $request, $id)
    {
        $seo = [
            "title" => "Все статьи. Страница - ".$id.".",
            "description" => "Все статьи. Страница - ".$id.".",
        ];

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        $posts = $posts = $this->postRepository->getPaginatedPostsOrderedById(false, $id);

        $pages = $this->paginatorService->calculatePages($posts);

        $previousNumberPage = $pages["previousPage"];
        $nextNumberPage = $pages["nextPage"];
        $lastNumberPage = $pages["lastPage"];

        $items = $posts;
        $items_to_display = 3;
        $paginated_route = '/admin/posts';

        return view('admin.posts', compact('seo', 'user', 'posts', 'previousNumberPage', 'nextNumberPage', 'lastNumberPage', 'items', 'paginated_route', 'items_to_display'));
    }

    public function comments(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        $comments = $this->commentService->getPaginatedComments(true);

        $unpublish_comments_count = $this->commentService->getCommentsNotVerifiedCount();

        $pages = $this->paginatorService->calculatePages($comments);

        $previousNumberPage = $pages["previousPage"];
        $nextNumberPage = $pages["nextPage"];
        $lastNumberPage = $pages["lastPage"];

        $items = $comments;
        $items_to_display = 3;
        $paginated_route = '/comments/page';

        $activeItem = $this->seoService->getRouteName($request);

        return view('admin.comments', compact('seo', 'comments', 'previousNumberPage',
            'nextNumberPage', 'lastNumberPage', 'user', 'unpublish_comments_count',
        'items', 'items_to_display', 'paginated_route', 'activeItem'));
    }

    public function commentsPaginate(Request $request, $id)
    {

        $seo = [
            "title" => "Все комментарии. Страница - ".$id.".",
            "description" => "Все комментарии. Страница - ".$id.".",
        ];

        $comments = $this->commentService->getPaginatedComments(false, $id);

        $pages = $this->paginatorService->calculatePages($comments);

        $previousNumberPage = $pages["previousPage"];
        $nextNumberPage = $pages["nextPage"];
        $lastNumberPage = $pages["lastPage"];

        $items = $comments;
        $items_to_display = 3;
        $paginated_route = '/comments/page';

        return view('admin.comments', compact('seo', 'comments', 'previousNumberPage', 'nextNumberPage', 'lastNumberPage',
            'items', 'items_to_display', 'paginated_route'
        ));
    }

    public function unpublished(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $comments = $this->commentService->getUnpublishedComments();

        $unpublish_comments_count = $this->commentService->getCommentsNotVerifiedCount();

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        return view('admin.unpublished', compact('seo', 'comments', 'user', 'unpublish_comments_count'));
    }
}
