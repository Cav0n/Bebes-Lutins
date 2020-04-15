<?php

namespace App\Http\Controllers\CustomerArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class MainController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | [AUTH] - CustomerArea\MainController
    |--------------------------------------------------------------------------
    |
    | This controller handle navigation in customer area.
    |
    */

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
     * Show home page.
     */
    public function index(Request $request)
    {
        return view('pages.customer_area.index');
    }

    /**
     * Show orders page.
     */
    public function orders(Request $request)
    {
        return view('pages.customer_area.orders')
            ->with([
                'orders' => Auth::user()->orders()->orderBy('created_at', 'desc')->paginate(15)
            ]);
    }

    /**
     * Show addresses page.
     */
    public function addresses(Request $request)
    {
        return view('pages.customer_area.addresses');
    }
}
