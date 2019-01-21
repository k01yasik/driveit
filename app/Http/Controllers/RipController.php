<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SeoService;
use App\Rip;
use Carbon\Carbon;

class RipController extends Controller
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|string'
        ]);

        $id = $data['id'];

        $rip = new Rip;
        $rip->user_id = $id;
        $rip->rip_date = Carbon::now();
        $rip->save();

        return
            [
                'status' => 'ok',
                'url' => route('admin.users')
            ];
    }

    public function destroy(Request $request)
    {
        $id = $request->query('id');

        $rip = Rip::where('user_id', $id)->firstOrFail();
        $rip->delete();

        event('eloquent.deleted: App\Rip', $rip);

        return 'ok';
    }
}
