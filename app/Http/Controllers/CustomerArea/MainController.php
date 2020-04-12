<?php

namespace App\Http\Controllers\CustomerArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('pages.customer_area.orders')->with(['orders' => Auth::user()->orders()->paginate(15)]);
    }

    /**
     * Redirect to customer area addresses page.
     */
    public function addresses(Request $request)
    {
        return view('pages.customer_area.addresses');
    }
}
