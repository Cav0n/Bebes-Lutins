<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Handle some page redirection in admin backoffice.
 */
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return redirect(route('admin.homepage'));
    }

    public function changelog()
    {
        return view('pages.admin.changelog');
    }

    public function homepage()
    {
        return view('pages.admin.homepage');
    }
}
