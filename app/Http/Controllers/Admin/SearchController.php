<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Search Controller
    |--------------------------------------------------------------------------
    |
    | This controller handle search in admin dashboard.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function orders(Request $request)
    {
        if (!$request['search']) {
            return redirect()->route('admin')->withErrors(['search' => 'La recherche ne peut pas être vide.']);
        }

        $orders = \App\Order::where('trackingNumber', 'like', '%' . $request['search'] . '%')->get();

        return view('pages.admin.index')->withOrders($orders)->withInSearch(true);
    }

    public function products(Request $request)
    {
        if (!$request['search']) {
            return redirect()->route('admin')->withErrors(['search' => 'La recherche ne peut pas être vide.']);
        }

        $products = \App\Product::where('name', 'like', '%' . $request['search'] . '%')->get();

        return view('pages.admin.products')->withProducts($products)->withInSearch(true);
    }

    public function categories(Request $request)
    {
        if (!$request['search']) {
            return redirect()->route('admin')->withErrors(['search' => 'La recherche ne peut pas être vide.']);
        }

        $categories = \App\Category::where('name', 'like', '%' . $request['search'] . '%')->get();

        return view('pages.admin.categories')->withCategories($categories)->withInSearch(true);
    }
}
