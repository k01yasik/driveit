<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeoStore;
use App\Http\Requests\SeoUpdate;
use App\Services\SeoService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeoController extends Controller
{
    protected SeoService $seoService;
    protected UserService $userService;

    public function __construct(SeoService $seoService, UserService $userService)
    {
        $this->seoService = $seoService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        $allSeo = $this->seoService->getAllData();

        $activeItem = $this->seoService->getRouteName($request);

        return view('admin.seo', compact('user', 'seo', 'allSeo', 'activeItem'));
    }

    public function create(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        return view('seo.create', compact('seo', 'user'));
    }

    public function store(SeoStore $request)
    {
        $data = $request->validated();

        $route = $data['route'];
        $title = $data['title'];
        $description = $data['description'];

        $this->seoService->store($route, $title, $description);

        return redirect()->route('admin.seo')->with('status', __('Seo entry successfully added'));
    }

    public function show(Request $request, $id)
    {
        list($seo, $user, $result) = $this->handler($request, $id);

        return view('seo.show', compact('seo', 'result', 'user'));
    }

    public function edit(Request $request, $id)
    {
        list($seo, $user, $result) = $this->handler($request, $id);

        return view('seo.edit', compact('seo', 'user', 'result'));
    }

    public function update(SeoUpdate $request, int $id)
    {
        $data = $request->validated();

        $title = $data['title'];
        $description = $data['description'];

        if ($this->seoService->update($id, $title, $description)) {
            return redirect()->route('seo.show', ['id' => $id]);
        } else {
            return back()->withInput();
        }
    }

    public function destroy(int $id)
    {
        $this->seoService->delete($id);

        return redirect()->route('admin.seo');
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     */
    private function handler(Request $request, $id): array
    {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'] . ' ' . $id;
        $seo['description'] = $seo['description'] . ' ' . $id;

        $user = $this->userService->getCurrentUserWithProfile(Auth::id());

        $result = $this->seoService->getSeoById($id);
        return array($seo, $user, $result);
    }
}
