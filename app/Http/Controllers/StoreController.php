<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SeoService;
use App\Services\StoreOffersService;
use App\Services\StoreService;
use App\Store;
use App\Sshina;
use App\SshinaCategory;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    protected $seoService;
    protected $storeService;
    protected $storeOffersService;

    public function __construct(SeoService $seoService, StoreService $storeService, StoreOffersService $storeOffers)
    {
        $this->seoService = $seoService;
        $this->storeService = $storeService;
        $this->storeOffersService = $storeOffers;
    }

    public function index(Request $request) {

        $seo = $this->seoService->getSeoData($request);

        $stores = $this->storeService->getStores();

        $sshinas = $this->storeOffersService->getSshinaOffers();

        return view('store.index', compact('seo', 'stores', 'sshinas'));
    }

    public function show(Request $request, $store) {

        $store = Store::where('name', $store)->firstOrFail();

        $seo = [
            'title' => 'Магазин '.$store->name,
            'description' => 'Товары магазина '.$store->name,
        ];

        $categories = DB::table($store->table_name)
            ->select(DB::raw('COUNT(1) count, category_id'))
            ->groupBy('category_id')
            ->get();

        $count_array = [];
        $categories_array = [];

        foreach ($categories as $category) {
            array_push($categories_array, $category->category_id);
            $count_array[$category->category_id] = $category->count;
        }

        $store_categories = SshinaCategory::whereIn('category_id', $categories_array)->get();

        foreach ($store_categories as $category) {
            $category->count = $count_array[$category->category_id];
        }

        debug($count_array);
        debug($store_categories);

        return view('store.show', compact('seo', 'store', 'store_categories'));
    }

    public function showCategory(Request $request, $store, $id) {

    }
}
