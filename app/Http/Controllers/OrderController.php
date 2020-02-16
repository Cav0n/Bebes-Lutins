<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
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
        $order = new Order();
        $order->status = 'WAIT_PAYMENT';
        $order->shippingCosts = $request['shippingCosts'];
        $order->billing_address_id = $request['billing_address_id'];
        $order->shipping_address_id = $request['shipping_address_id'];
        $order->user_id = $request['user_id'];
        $order->voucher_id = $request['voucher_id'];

        $order->save();
    }

    public function createFromCart(Request $request, \App\Cart $cart)
    {
        $order = new Order();
        $order->status = 'WAIT_PAYMENT';
        $order->shippingCosts = $cart->shippingCosts;
        $order->paymentMethod = $request['paymentMethod'];
        $order->billing_address_id = $cart->billingAddress->id;
        if ($cart->shippingAddress) $order->shipping_address_id = $cart->shippingAddress->id;
        if ($cart->user) $order->user_id = $cart->user->id;
        $order->voucher_id = $cart->voucher_id;

        $order->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
