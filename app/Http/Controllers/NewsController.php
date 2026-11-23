<?php

namespace App\Http\Controllers;

use App\Services\NewsService;
use App\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use App\Http\Requests\NewsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    public function __construct(
        private NewsService $newsService
    ) {
    }

    public function index(): View
    {
        $news = $this->newsService->getLastNews();
        return view('news.index', compact('news'));
    }

    public function adminIndex(): View
    {
        return view('news.admin-index', ['news' => News::query()->latest('id')->paginate(15)]);
    }

    public function list(): View
    {
        $news = $this->newsService->getPaginatedNews();
        return view('news.list', compact('news'));
    }

    public function store(NewsRequest $request): JsonResponse|RedirectResponse
    {
        try {
            $data = $request->validated();
            $data += ['image_path' => '', 'is_published' => false];
            $data['image_path'] ??= '';
            $data['slug'] = Str::limit(Str::slug($data['title']), 145, '').'-'.Str::uuid();
            $data['name'] = $data['title'];
            $data['caption'] = $data['description'];
            $data['user_id'] = $request->user()->id;
            $data['views'] = 0;

            if ($data['is_published']) {
                $data['date_published'] ??= now();
            }

            $news = $this->newsService->create($data);

            if (! $request->expectsJson()) {
                return redirect()->route('admin.news.index');
            }

            return response()->json($news, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            if (! $request->expectsJson()) {
                report($e);
                return back()->withInput()->withErrors(['title' => __('Failed to create news')]);
            }

            return response()->json([
                'message' => 'Failed to create news'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(NewsRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $success = $this->newsService->update($id, $data);
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update news'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $success = $this->newsService->delete($id);
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete news'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function publishToggle(int $id): JsonResponse
    {
        try {
            $success = $this->newsService->togglePublish($id);
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to toggle publish status'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
