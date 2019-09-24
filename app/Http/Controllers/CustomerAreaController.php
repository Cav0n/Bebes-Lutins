<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerAreaController extends Controller
{
    public function index(){

    }

    public function loginPage(){
        return view('pages.customer-area.login');
    }

    public function login(Request $request){
        dd($request);
    }

    public function registerPage(){
        return view('pages.customer-area.register');
    }

    public function register(Request $request){
        dd($request);
    }

    public function profilPage(){
        return view('pages.customer-area.profil');
    }

    public function ordersPage(){
        return view('pages.customer-area.orders');
    }

    public function addressPage(){
        return view('pages.customer-area.address');
    }
}
