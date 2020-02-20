<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeoStore;
use App\Http\Requests\SeoUpdate;
use App\Repositories\CachedUserRepository;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeoController extends Controller
{
    protected $seoService;
    protected $userRepository;

    public function __construct(SeoService $seoService, CachedUserRepository $userRepository)
    {
        $this->seoService = $seoService;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $user = $this->userRepository->getCurrentUserWithProfile(Auth::id());

        $allSeo = $this->seoService->getAllData();

        return view('admin.seo', compact('user', 'seo', 'allSeo'));
    }

    public function create(Request $request)
    {
        $seo = $this->seoService->getSeoData($request);

        $user = $this->userRepository->getCurrentUserWithProfile(Auth::id());

        return view('seo.create', compact('seo', 'user'));
    }

    public function store(SeoStore $request)
    {
        $data = $request->validated();

        $this->seoService->store($data);

        return redirect()->route('admin.seo')->with('status', __('Seo entry successfully added'));
    }

    public function show(Request $request, $id)
    {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$id;
        $seo['description'] = $seo['description'].' '.$id;

        $user = $this->userRepository->getCurrentUserWithProfile(Auth::id());

        $result = $this->seoService->getSeoById($id);

        return view('seo.show', compact('seo', 'result', 'user'));
    }

    public function edit(Request $request, $id)
    {
        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$id;
        $seo['description'] = $seo['description'].' '.$id;

        $user = $this->userRepository->getCurrentUserWithProfile(Auth::id());

        $result = $this->seoService->getSeoById($id);

        return view('seo.edit', compact('seo', 'user', 'result'));
    }

    public function update(SeoUpdate $request, int $id)
    {
        $data = $request->validated();

        $result = $this->seoService->getSeoById($id);
        $result->title = $data['title'];
        $result->description = $data['description'];
        $ok = $result->save();

        if ($ok) {
            return redirect()->route('seo.show', ['id' => $id]);
        } else {
            return back()->withInput();
        }
    }

    public function destroy(int $id)
    {
        $result = $this->seoService->getSeoById($id);
        try {
            $ok = $result->delete();
        } catch (\Exception $e) {
        }

        if ($ok) {
            return redirect()->route('admin.seo');
        } else {
            return back();
        }
    }
}
