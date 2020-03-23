<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DraftService;
use App\Http\Requests\DraftRequest;

class DraftController extends Controller
{
    protected $draftService;

    public function __construct(DraftService $draftService)
    {
        $this->draftService = $draftService;
    }

    public function index()
    {
        $drafts = $this->draftService->getUserDrafts();

        return view('draft.index', compact('drafts'));
    }

    public function store(DraftRequest $draftRequest)
    {
        $data = $draftRequest.validated();

        $this->draftService->store($data);

        return redirect()->route('draft.index');
    }
}
