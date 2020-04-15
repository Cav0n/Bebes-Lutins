<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | [ADMIN] - AdminController
    |--------------------------------------------------------------------------
    |
    | This controller handle main navigation in BackOffice.
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

    /**
     * Redirect to backoffice homepage.
     *
     * @return \Illuminate\Routing\Redirector;
     */
    public function index()
    {
        return redirect(route('admin.homepage'));
    }

    /**
     * Show changelog page.
     *
     * @return Illuminate\View\View
     */
    public function changelog()
    {
        return view('pages.admin.changelog');
    }

    /**
     * Show backoffice homepage.
     *
     * @return Illuminate\View\View
     */
    public function homepage()
    {
        return view('pages.admin.homepage');
    }
}
