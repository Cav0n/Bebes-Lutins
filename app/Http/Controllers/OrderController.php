<?php

namespace App\Http\Controllers;

use View;
use App\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function showTrackingPage()
    {
        return view('pages.order.tracking');
    }

    public function tracking(Request $request, string $trackingNumber)
    {
        if (null !== $order = Order::where('trackingNumber', $trackingNumber)->first()){
            return JsonResponse::create(['order' => View::make('components.utils.orders.order', ['order' => $order, 'bgColor' => 'bg-white'])
                                                    ->render()]);
        }

        return JsonResponse::create(['error' => ['message' => trans('messages.There is no order with this tracking number.')] ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = \App\Order::orderBy('created_at', 'desc')->get();

        return view('pages.admin.index')->withOrders($orders);
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
        $order->email = $request['email'];
        $order->phone = $request['phone'];
        $order->billing_address_id = $request['billing_address_id'];
        $order->shipping_address_id = $request['shipping_address_id'];
        $order->user_id = $request['user_id'];
        $order->voucher_id = $request['voucher_id'];

        $order->save();
    }

    public function createFromCart(Request $request, \App\Cart $cart)
    {
        $order = new Order();
        $order->status = 'WAITING_PAYMENT';
        $order->shippingCosts = $cart->shippingCosts;
        $order->paymentMethod = $request['paymentMethod'];
        $order->email = $cart->email;
        $order->phone = $cart->phone;

        $order->billing_address_id = $cart->billingAddress->id;
        if ($cart->shippingAddress) $order->shipping_address_id = $cart->shippingAddress->id;
        if ($cart->user) $order->user_id = $cart->user->id;
        $order->voucher_id = $cart->voucher_id;

        $order->trackingNumber = uniqid();

        $order->save();

        foreach($cart->items as $item){
            $orderItem = new \App\OrderItem();
            $orderItem->quantity = $item->quantity;
            $orderItem->unitPrice = $item->product->price;
            $orderItem->product_id = $item->product->id;
            $orderItem->order_id = $order->id;

            $orderItem->save();
        }

        $cart = session()->get('shopping_cart');
        $cart->isActive = 0;
        $cart->save();

        session()->forget('shopping_cart');
        session()->regenerate();

        return redirect(route('thanks', ['order' => $order]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('pages.admin.order')->withOrder($order);
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
        if (null !== $status = $request['status']) {
            $order->status = $status;
        }

        $order->save();

        return new JsonResponse(['message' => 'ok', 'color' => $order->statusColor], 200);
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
