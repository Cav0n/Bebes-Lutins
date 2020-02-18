<?php

namespace App\Http\Controllers;

use Session;
use Auth;
use App\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
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
    public function create(\App\User $user = null, string $sessionId = null)
    {
        $cart = new Cart();
        $cart->isActive = true;
        $cart->sessionId = $sessionId;
        if ($user) $cart->user_id = $user->id;
        $cart->save();

        session()->put('shopping_cart', $cart);
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
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart = null)
    {
        return view('pages.shopping_cart.index');
    }

    public function showDelivery()
    {
        return view('pages.shopping_cart.delivery');
    }

    public function addAddresses(Request $request)
    {
        $addressController = new AddressController();
        $billingAddressId = $addressController->storeArray($request->input('billing'), Auth::user());

        $shippingAddressId = null;
        if(null === $request->input('sameAddress') || !$request->input('sameAddress')){
            $shippingAddressId = $addressController->storeArray($request->input('shipping'), Auth::user());
        }

        $cart = session()->get('shopping_cart');
        $cart->billing_address_id = $billingAddressId;
        $cart->shipping_address_id = $shippingAddressId;
        $cart->save();

        session()->put('shopping_cart', $cart);

        return redirect(route('cart.payment'));
    }

    public function showPayment()
    {
        return view('pages.shopping_cart.payment');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
