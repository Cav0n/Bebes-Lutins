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
     * Redirect to customer area home page
     */
    public function index(Request $request)
    {
        return view('pages.customer_area.index');
    }
}
