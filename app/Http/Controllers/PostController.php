<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStore;
use Illuminate\Http\Request;
use App\Services\SeoService;
use App\Post;
use App\Category;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PostController extends Controller
{
    protected $seoService;
    protected $commentService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);
        $categories = Category::where('has_child', 0)->get();

        return view('admin.posts.create', compact('seo', 'categories'));
    }

    /**
     * @param PostStore $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostStore $request)
    {
        $data = $request->validated();

        $post = new Post;
        $post->slug = $data['slug'];
        $post->title = $data['title'];
        $post->description = $data['description'];
        $post->name = $data['name'];
        $post->caption = $data['caption'];
        $post->body = $data['body'];
        $post->image_path = $data['image'];
        $post->is_published = 0;
        $post->user()->associate(Auth::user());
        $post->views = 0;
        $post->save();

        $category = Category::find($data['category']);

        $arrayCategoryId = [];

        if ($category->parent_id) {
            array_push($arrayCategoryId, $category->parent_id);
        }

        array_push($arrayCategoryId, $category->id);

        $post->categories()->attach($arrayCategoryId);

        return redirect()->route('admin.posts');
    }

    public function update($id, PostStore $request)
    {
        $data = $request->validated();

        $post = Post::find($id);
        $post->title = $data['title'];
        $post->description = $data['description'];
        $post->name = $data['name'];
        $post->caption = $data['caption'];
        $post->body = $data['body'];
        $post->image_path = $data['image'];
        $post->user()->associate(Auth::user());
        $post->save();

        $category = Category::find($data['category']);

        $arrayCategoryId = [];

        if ($category->parent_id) {
            array_push($arrayCategoryId, $category->parent_id);
        }

        array_push($arrayCategoryId, $category->id);

        $post->categories()->detach();

        $post->categories()->attach($arrayCategoryId);

        return redirect()->route('admin.posts.show', ['id' => $id]);
    }

    public function show($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $post = Post::with(['user', 'categories', 'user.profile'])->where('id', $id)->firstOrFail();

        return view('admin.posts.show', compact('seo', 'post'));
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

        return view('admin.posts.html', compact('seo', 'post'));
    }
}
