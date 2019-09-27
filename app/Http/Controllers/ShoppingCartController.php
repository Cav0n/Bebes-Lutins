<?php

namespace App\Http\Controllers;

use App\ShoppingCart;
use Illuminate\Http\Request;
use Auth;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function show(ShoppingCart $shoppingCart = null, Request $request)
    {   
        $user_id = null;
        if($shoppingCart == null){

            if(Auth::check()){
                $user = Auth::user();
                $user_id = $user->id;

                if(session('shopping_cart') != null){ // Verify if user was connected and update session if so
                    $shoppingCart = session('shopping_cart');
                    $shoppingCart->user_id = $user_id;
                    $shoppingCart->save();
                } else if($user->shopping_cart_active->first() != null){ // Else verify if user had shopping cart active
                    $shoppingCart = $user->shopping_cart_active;
                }
            } else if(session('shopping_cart') != null){ // If user not connected verify shopping cart in session
                $shoppingCart = session('shopping_cart');
            }
            
            if($shoppingCart == null){ // If shopping cart is null create a new one
                $shoppingCart = new ShoppingCart();
                $shoppingCart->id = uniqid();
                $shoppingCart->user_id = $user_id;
                $shoppingCart->isActive = true;
                $shoppingCart->save();
            }

            session(['shopping_cart' => $shoppingCart]);
        }

        return view('pages.shopping-cart.index')->withShoppingCart($shoppingCart);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function edit(ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingCart $shoppingCart)
    {
        //
    }
}
