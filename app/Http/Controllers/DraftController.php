<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DraftService;
use App\Http\Requests\DraftRequest;
use App\Services\SeoService;
use App\Repositories\CachedUserRepository;
use App\Repositories\Interfaces\FriendRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class DraftController extends Controller
{
    protected $draftService;
    protected $seoService;
    protected $userRepository;
    protected $friendRepository;

    public function __construct(DraftService $draftService, 
                                SeoService $seoService,
                                CachedUserRepository $userRepository,
                                FriendRepositoryInterface $friendRepository)
    {
        $this->draftService = $draftService;
        $this->seoService = $seoService;
        $this->userRepository = $userRepository;
        $this->friendRepository = $friendRepository;
    }

    public function index(Request $request, $username)
    {
        $drafts = $this->draftService->getUserDrafts();

        $seo = $this->seoService->getSeoData($request);

        $seo['title'] = $seo['title'].' '.$username;
        $seo['description'] = $seo['description'].' '.$username;

        return view('draft.index', compact('drafts', 'seo'));
    }

    public function store(DraftRequest $draftRequest)
    {
        $data = $draftRequest.validated();

        $result = $this->draftService->store($data);

        if ($result) {
            return redirect()->route('draft.index');
        }
        
        return redirect()->back();
    }

    public function show(Request $request, $username, App\Draft $draft)
    {
        $seo = $this->seoService->getSeoData($request);

        return view('draft.show', compact('seo', 'draft'));
    }
}
