<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStore;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\SeoService;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected SeoService $seoService;
    protected CategoryService $categoryService;
    protected PostService $postService;
    protected UserService $userService;

    public function __construct(SeoService $seoService,
                                CategoryService $categoryService,
                                PostService $postService,
                                UserService $userService)
    {
        $this->seoService = $seoService;
        $this->categoryService = $categoryService;
        $this->postService = $postService;
        $this->userService = $userService;
    }

    public function create(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $categories = $this->categoryService->getAllParentCategories();

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        $create = true;

        return view('admin.posts.create', compact('seo', 'categories', 'user', 'create'));
    }

    public function store(PostStore $request)
    {
        list($postEntity, $postCategoriesId) = $this->handler($request);

        $this->postService->store($postEntity, Auth::id(), $postCategoriesId);

        return redirect()->route('admin.posts');
    }

    public function update($id, PostStore $request)
    {
        list($postEntity, $postCategoriesId) = $this->handler($request);

        $this->postService->update($postEntity, Auth::id(), $id, $postCategoriesId);

        return redirect()->route('admin.posts.show', ['id' => $id]);
    }

    public function updateHtml($id, PostStore $request)
    {
        list($postEntity, ) = $this->handler($request);

        $this->postService->updateHtml($postEntity, $id);

        return redirect()->route('admin.posts.show', ['id' => $id]);
    }

    public function show($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $post = $this->postService->getPostByIdWithUserData($id);

        $post->rating_count = $this->postService->countPostRating($post['rating']);

        $post->comments_count = $this->postService->countPostComments($post['comments']);

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        return view('admin.posts.show', compact('seo', 'post', 'user'));
    }

    public function publish(Request $request)
    {
        $post = $this->postService->getById($request->id);

        if ($post['is_published']) {
            $post['is_published'] = 0;
        } else {
            $post['is_published'] = 1;
            $post['data_published'] = Carbon::now();
        }

        $postEntity = $this->postService->restorePost(
            $post['id'],
            $post['slug'],
            $post['title'],
            $post['description'],
            $post['name'],
            $post['caption'],
            $post['body'],
            $post['imagePath'],
            $post['is_published'],
            $post['views'],
            $post['data_published']
        );

        $this->postService->changePublishStatus($postEntity);
    }

    public function edit($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $post = $this->postService->getPostByIdWithCategories($id);

        $categories = $this->categoryService->getAllParentCategories();

        $categoryArray = $this->categoryService->getPostCategoriesIdByPost($post);

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        return view('admin.posts.edit', compact('seo', 'post', 'categories', 'categoryArray', 'user'));
    }

    public function editHtml($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $post = $this->postService->getById($id);

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        return view('admin.posts.html', compact('seo', 'post', 'user'));
    }

    /**
     * @param PostStore $request
     * @return array
     */
    protected function handler(PostStore $request): array
    {
        $data = $request->validated();

        $postEntity = $this->postService->createPost(
            $data['slug'],
            $data['title'],
            $data['description'],
            $data['name'],
            $data['caption'],
            $data['body'],
            $data['image']
        );

        $categoryId = $data['category'];

        $category = $this->categoryService->getPostCategory($categoryId);

        $postCategoriesId = $this->categoryService->getPostAllCategoriesId($category);

        return array($postEntity, $postCategoriesId);
    }
}
