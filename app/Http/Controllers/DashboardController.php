<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
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

    public function index(){
        return redirect('/dashboard/commandes');
    }

    public function orders(string $status = null){
        switch($status){
            case 'en-cours':
                $status = "en cours";
                break;

            case 'terminees':
                $status = "terminées";
                break;

            case 'refusees':
                $status = "refusées";
                break;
        }
        return view('pages.dashboard.orders')->withStatus($status);
    }

    public function products(){
        return view('pages.dashboard.products');
    }

    public function stocks(){
        return view('pages.dashboard.stocks');
    }

    public function categories(){
        return view('pages.dashboard.categories');
    }

    public function customers(){

    }

    public function reviews(){

    }

    public function vouchers(){

    }

    public function newsletters(){

    }
}
