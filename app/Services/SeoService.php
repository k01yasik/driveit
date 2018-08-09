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

class SeoService
{
    public function getSeoData(Request $request)
    {
        $route_name = $request->route()->getName();
        return Seo::where('route_name', $route_name)->firstOrFail();
    }
}