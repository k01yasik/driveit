<?php

namespace App\Http\Controllers;

use App\Services\RipService;
use Illuminate\Http\Request;
use App\Http\Requests\RipRequest;
use App\Services\SeoService;

class RipController extends Controller
{
    protected $seoService;
    protected $ripService;

    public function __construct(SeoService $seoService, RipService $ripService)
    {
        $this->seoService = $seoService;
        $this->ripService = $ripService;
    }

    public function store(RipRequest $request)
    {
        $data = $request->validated();

        $this->ripService->store($data['id']);

        return
            [
                'status' => 'ok',
                'url' => route('admin.users')
            ];
    }

    public function destroy(Request $request)
    {
        $id = $request->query('id');

        $rip = $this->ripService->delete($id);

        event('eloquent.deleted: App\Rip', $rip);

        return response('ok', 200);
    }
}
