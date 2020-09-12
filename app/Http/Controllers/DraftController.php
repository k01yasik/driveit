<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DraftService;
use App\Http\Requests\DraftRequest;
use App\Services\SeoService;
use Illuminate\Support\Facades\Auth;
use App\Dto\Draft as DraftDto;
use App\Draft;

class DraftController extends Controller
{
    protected DraftService $draftService;
    protected SeoService $seoService;

    public function __construct(DraftService $draftService, 
                                SeoService $seoService)
    {
        $this->draftService = $draftService;
        $this->seoService = $seoService;
    }

    public function index(Request $request, $username)
    {
        $drafts = $this->draftService->getUserDrafts(Auth::id());

        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        return view('draft.index', compact('drafts', 'seo'));
    }

    public function store(DraftRequest $draftRequest)
    {
        $data = $draftRequest->validated();

        $draft = new DraftDto(
            $data['slug'],
            $data['title'],
            $data['description'],
            $data['name'],
            $data['caption'],
            $data['body'],
            $data['image']
        );

        $this->draftService->save($draft, Auth::id());

        return redirect()->route('draft.index');
    }

    public function show(Request $request, $username, Draft $draft)
    {
        $seo = $this->seoService->getSeoData($request);

        return view('draft.show', compact('seo', 'draft'));
    }
}
