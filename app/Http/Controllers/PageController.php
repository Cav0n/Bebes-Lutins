<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PageController extends Controller
{
    public function index()
    {
        if(session('shopping-cart') == null){
            if(Auth::check()){
                $shoppingCart = Auth::user()->shopping_cart_active[0];
                session(['shopping_cart' => $shoppingCart]);
            }

            if(!isset($shoppingCart)){
                ShoppingCartController::createNew();
            }
        }

        return view('homepage');
    }
}
