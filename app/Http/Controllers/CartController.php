<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Cart Model controller.
 * Handle cart creation, and different steps (addresses addition, payment selection).
 */
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
        $cart = Session::get('shopping_cart');
        $step = 1;

        if ($cart->items->isEmpty()) {
            $step = 0;
        }

        return view('pages.shopping_cart.index')
                ->withCartStep($step)
                ->withCart($cart);
    }

    public function showDelivery()
    {
        $cart = Session::get('shopping_cart');
        $step = 2;

        return view('pages.shopping_cart.delivery')
                ->withCartStep($step)
                ->withCart($cart);
    }

    public function addAddresses(Request $request)
    {
        $addressController = new AddressController();

        $request->validate([
            'email' => ['required', 'email:filter'],
        ]);

        // Billing address creation
        if ($request->input('is-new-billing-address')){
            $billingAddressId = $addressController->store($request, 'billing');
        } else {
            $billingAddressId = $request->input('billing-address-id');
        }

        // Shipping address creation
        if (null !== $request->input('sameAddresses') && $request->input('sameAddresses')) {
            $shippingAddressId = $billingAddressId;
        } else {
            if ($request->input('is-new-shipping-address')){
                $shippingAddressId = $addressController->store($request, 'shipping');
            } else {
                $shippingAddressId = $request->input('shipping-address-id');
            }
        }

        $cart = session()->get('shopping_cart');

        $cart->email = $request->input('email');
        $cart->phone = $request->input('phone');

        $cart->billing_address_id = $billingAddressId;
        $cart->shipping_address_id = $shippingAddressId;
        $cart->save();

        session()->put('shopping_cart', $cart);

        return redirect(route('cart.payment'));
    }

    public function showPayment()
    {
        $cart = Session::get('shopping_cart');
        $step = 3;

        return view('pages.shopping_cart.payment')
                ->withCartStep($step)
                ->withCart($cart);
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
