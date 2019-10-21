<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getJSON(Order $order)
    {
        $order_array = array();
        $order_array['id'] = $order->id;
        $order_array['status'] = $order->status;
        $order_array['shipping_price'] = $order->shippingPrice;
        $order_array['products_price'] = $order->productsPrice;
        $order_array['payment_method'] = $order->paymentMethod;
        
        $order_array['customer_message'] = $order->customerMessage;
        $order_array['shipping_address_id'] = $order->shipping_address_id;
        $order_array['billing_address_id'] = $order->billing_address_id;
        $order_array['is_canceled'] = $order->isCanceled;
        $order_array['created_at'] = $order->created_at;
        $order_array['updated_at'] = $order->updated_at;
        $order_array['user'] = $order->user;
        $order_array['voucher'] = $order->voucher;
        $order_array['items'] = $order->order_items;
        
        $data = [ 
            'order' => $order_array
        ];

        header('Content-type: application/json');
        echo json_encode( $data, JSON_PRETTY_PRINT);
    }

    public function search(Request $request)
    {
        $search_words = array_unique(preg_split('/ +/', mb_strtoupper($request['search'])));
        $selected_products = array();
        $selected_orders = array();

        $products = Product::all();
        $orders = Order::all();
        foreach($products as $product){
            if(Str::contains(mb_strtoupper($product->name), $search_words)) $selected_products[] = $product;
        }

        foreach($orders as $order){
            if(Str::contains(mb_strtoupper($order->user->firstname), $search_words)) $selected_orders[] = $order; break;
            if(Str::contains(mb_strtoupper($order->user->lastname), $search_words)) $selected_orders[] = $order; break;
            foreach($order->order_items as $item){
               foreach($selected_products as $selected_product){
                   if($item->product->id == $selected_product->id) $selected_orders[] = $order; break;
               } 
            }
        }

        //dd(array_unique($selected_orders));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd(Order::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('A DESACTIVER - PAS BESOIN DE PAGE DE CREATION');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        dd($order);
    }

    public function showThanks()
    {
        dd('Merci');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        dd('A DESACTIVER - PAS BESOIN DE PAGE D\'ÉDITION');
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
        $order->status = $request['status'];
        $order->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        dd($order);
    }
}
