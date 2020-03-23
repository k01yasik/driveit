<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $data = $draftService.validated();



        return redirect()->route('draft.index');
    }
}
