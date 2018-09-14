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
        $post->rating = 0;
        $post->views = 0;
        $post->comments = 0;
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

    public function show($id, Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        return view('admin.posts.show', compact('seo'));
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
}
