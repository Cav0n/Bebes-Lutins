<?php

namespace App\Http\Controllers\CustomerArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Redirect to customer area home page.
     */
    public function index(Request $request)
    {
        return view('pages.customer_area.index');
    }

    /**
     * Redirect to customer area orders page.
     */
    public function orders(Request $request)
    {
        return view('pages.customer_area.orders');
    }

    /**
     * Redirect to customer area addresses page.
     */
    public function addresses(Request $request)
    {
        return view('pages.customer_area.addresses');
    }
}
