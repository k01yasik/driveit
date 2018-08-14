<?php
/**
 * Created by PhpStorm.
 * User: Bzdykin
 * Date: 07.08.2018
 * Time: 20:03
 */

namespace App\Services;

use App\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SeoService
{
    public function getSeoData(Request $request)
    {
        $route_name = $request->route()->getName();
        $seoData = Cache::rememberForever($route_name, function () use ($route_name) {
            return Seo::where('route_name', $route_name)->firstOrFail();
        });
        return $seoData;
    }
}