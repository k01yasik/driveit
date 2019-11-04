<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStore;
use App\Http\Requests\UpdateHtml;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\CategoryService;
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

    public function __construct(SeoService $seoService, PostRepositoryInterface $post, CategoryRepositoryInterface $category, CategoryService $categoryService)
    {
        $this->seoService = $seoService;
        $this->post = $post;
        $this->category = $category;
        $this->categoryService = $categoryService;
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

        $user_id = Auth::id();

        $user = Cache::rememberForever('user_with_profile_'.$user_id, function () use ($user_id) {
            return User::with('profile')->where('id', $user_id)->firstOrFail();
        });

        return view('admin.posts.show', compact('seo', 'post', 'user'));
    }

    /**
     * @param Request $request
     */
    public function publish(Request $request)
    {
        $id = $request->id;

        $post = Post::find($id);

        if ($post->is_published) {
            $post->is_published = 0;
        } else {
            $post->is_published = 1;
            $post->date_published = Carbon::now();
        }

        $post->save();
    }

    public function edit($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $post = Post::with('categories')->where('id', $id)->firstOrFail();

        $categories = Category::where('has_child', 0)->get();

        $categoryArray = [];

        foreach ($post->categories as $category) {
            array_push($categoryArray, $category->id);
        }

        return view('admin.posts.edit', compact('seo', 'post', 'categories', 'categoryArray'));
    }

    public function editHtml($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $post = Post::where('id', $id)->firstOrFail();

        $user_id = Auth::id();

        $user = Cache::rememberForever('user_with_profile_'.$user_id, function () use ($user_id) {
            return User::with('profile')->where('id', $user_id)->firstOrFail();
        });

        return view('admin.posts.html', compact('seo', 'post', 'user'));
    }
}
