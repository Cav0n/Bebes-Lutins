<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Http\Requests\Login; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAreaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only('index', 'profilPage', 'ordersPage', 'addressPage');
    }

    public function index(){
        if (Auth::check()) {
            return redirect('/espace-client/profil');
        } else return redirect('/espace-client/connexion');
    }

    public function loginPage(){
        if (Auth::check()) {
            return redirect('/espace-client/profil');
        } else return view('pages.customer-area.login');
    }

    public function login(Login $request){
        if (Auth::check()) {
            return redirect('/espace-client/profil');
        } else return redirect('/login');
    }

    public function registerPage(){
        if (Auth::check()) {
            return redirect('/espace-client/profil');
        } else return view('pages.customer-area.register');
    }

    public function register(Request $request){
        if (Auth::check()) {
            return redirect('/espace-client/profil');
        } else return redirect('/register');
    }

    public function profilPage(){
        return view('pages.customer-area.profil');
    }

    public function ordersPage(){
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('pages.customer-area.orders')->withOrders($orders);
    }

    public function addressPage(){
        return view('pages.customer-area.address');
    }
}
