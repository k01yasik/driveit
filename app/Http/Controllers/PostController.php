<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStore;
use App\Http\Requests\UpdateHtml;
use App\Repositories\CachedUserRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\CategoryService;
use App\Services\PostService;
use Illuminate\Http\Request;
use App\Services\SeoService;
use App\Post;
use App\Category;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PostController extends Controller
{
    protected $seoService;
    protected $commentService;
    protected $post;
    protected $category;
    protected $categoryService;
    protected $postService;
    protected $cachedUser;

    public function __construct(SeoService $seoService, PostRepositoryInterface $post,
                                CategoryRepositoryInterface $category, CategoryService $categoryService,
                                PostService $postService, CachedUserRepository $cachedUser)
    {
        $this->seoService = $seoService;
        $this->post = $post;
        $this->category = $category;
        $this->categoryService = $categoryService;
        $this->postService = $postService;
        $this->cachedUser = $cachedUser;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $categories = $this->category->getAllParentCategories();

        return view('admin.posts.create', compact('seo', 'categories'));
    }

    /**
     * @param PostStore $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostStore $request)
    {
        $data = $request->validated();

        $post = $this->post->store($data);

        $category = $this->category->getPostCategory($data['category']);

        $postCategoriesId = $this->categoryService->getPostAllCategoriesId($category);

        $post->categories()->attach($postCategoriesId);

        return redirect()->route('admin.posts');
    }

    public function update($id, PostStore $request)
    {
        $data = $request->validated();

        $post = $this->post->update($id, $data);

        $category = $this->category->getPostCategory($data['category']);

        $postCategoriesId = $this->categoryService->getPostAllCategoriesId($category);

        $post->categories()->detach();

        $post->categories()->attach($postCategoriesId);

        return redirect()->route('admin.posts.show', ['id' => $id]);
    }

    public function updateHtml($id, UpdateHtml $request)
    {
        $data = $request->validated();

        $this->post->updateHtml($id, $data);

        return redirect()->route('admin.posts.show', ['id' => $id]);
    }

    public function show($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $post = $this->post->getPostByIdWithUserData($id);

        $this->postService->countPostRating($post);

        $this->postService->countPostComments($post);

        $auth_id = Auth::id();

        $user = $this->cachedUser->getCurrentUserWithProfile($auth_id);

        return view('admin.posts.show', compact('seo', 'post', 'user'));
    }

    /**
     * @param Request $request
     */
    public function publish(Request $request)
    {
        $id = $request->id;

        $post = $this->post->getById($id);

        $post = $this->post->togglePublish($post);

        $post->save();
    }

    public function edit($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $post = $this->post->getPostByIdWithCategories($id);

        $categories = $this->category->getAllParentCategories();

        $categoryArray = $this->categoryService->getPostCategoriesIdByPost($post);

        return view('admin.posts.edit', compact('seo', 'post', 'categories', 'categoryArray'));
    }

    public function editHtml($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $post = $this->post->getById($id);

        $auth_id = Auth::id();

        $user = $this->cachedUser->getCurrentUserWithProfile($auth_id);

        return view('admin.posts.html', compact('seo', 'post', 'user'));
    }
}
