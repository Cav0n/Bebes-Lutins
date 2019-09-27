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

        //dd(session('shopping_cart'));

        if($shoppingCart == null){

            if(session('shopping_cart') != null){
                $shoppingCart = session('shopping_cart');
            }
            else if(Auth::check()){
                $user = Auth::user();
                $user_id = $user->id;
                $shoppingCart = $user->shopping_cart_active;
            }

            if($shoppingCart == null){
                $shoppingCart = new ShoppingCart();
                $shoppingCart->id = uniqid();
                $shoppingCart->user_id = $user_id;
                $shoppingCart->isActive = true;
                $shoppingCart->save();
            }

            session(['shopping_cart' => $shoppingCart]);
        }

        //dd(session('shopping_cart'));

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
