<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStore;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\UserService;
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

        $categories = $this->categoryService->getCategoriesForPostForm();

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

        $post = $this->postService->calculatePostStats($this->postService->getPostByIdWithUserData($id));

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        return view('admin.posts.show', compact('seo', 'post', 'user'));
    }

    public function publish(Request $request, int $id)
    {
        $this->postService->publish($id);

        return $request->expectsJson() ? response()->noContent() : back();
    }

    public function unpublish(Request $request, int $id)
    {
        $this->postService->unpublish($id);

        return $request->expectsJson() ? response()->noContent() : back();
    }

    public function archive(Request $request, int $id)
    {
        $this->postService->archive($id);

        return $request->expectsJson() ? response()->noContent() : back();
    }

    public function restore(Request $request, int $id)
    {
        $this->postService->restore($id);

        return $request->expectsJson() ? response()->noContent() : back();
    }

    public function edit($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $post = $this->postService->getPostByIdWithCategories($id);

        $categories = $this->categoryService->getCategoriesForPostForm();

        $selectedCategoryId = $this->categoryService->getSelectedCategoryId(collect($post['categories']));

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        return view('admin.posts.edit', compact('seo', 'post', 'categories', 'selectedCategoryId', 'user'));
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
            $data['slug'] ?? '',
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
