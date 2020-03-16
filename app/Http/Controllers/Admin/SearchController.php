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

    public function order(Request $request)
    {
        if (!$request['search']) {
            return redirect()->route('admin')->withErrors(['search' => 'La recherche ne peut pas être vide.']);
        }

        $orders = \App\Order::where('trackingNumber', 'like', '%' . $request['search'] . '%')->get();

        return view('pages.admin.index')->withOrders($orders)->withInSearch(true);
    }
}
