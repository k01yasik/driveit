<?php

namespace App\Http\Controllers;

use App\Services\RipService;
use Illuminate\Http\Request;
use App\Http\Requests\RipRequest;
use App\Services\SeoService;

class RipController extends Controller
{
    protected SeoService $seoService;
    protected RipService $ripService;

    public function __construct(SeoService $seoService, RipService $ripService)
    {
        $this->seoService = $seoService;
        $this->ripService = $ripService;
    }

    public function store(RipRequest $request)
    {
        $userId = $request->validated()['id'];

        $this->ripService->store($userId);

        return
            [
                'status' => 'ok',
                'url' => route('admin.users')
            ];
    }

    public function destroy(Request $request)
    {
        $id = $request->query('id');

        $this->ripService->delete($id);

        return response('ok', 200);
    }
}
