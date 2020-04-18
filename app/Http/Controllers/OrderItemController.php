<?php

namespace App\Http\Controllers;

use App\OrderItem;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class OrderItemController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | OrderItemController
    |--------------------------------------------------------------------------
    |
    | This controller handle OrderItem model.
    |
    */

    public function __construct()
    {
        $this->middleware('admin')->only(['index', 'create', 'store', 'edit', 'update']);
    }

    public function importFromJSON()
    {
        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/orders/items');
        $result = json_decode($res->getBody());

        OrderItem::destroy(OrderItem::all());

        $count = 0;
        foreach ($result as $r) {
            $orderItem = new OrderItem();
            $orderItem->quantity = $r->quantity;
            $orderItem->unitPrice = $r->unitPrice;
            $orderItem->order_id = \App\Order::where('email', $r->order->user->email)->where('created_at', $r->order->created_at)->first()->id; // PAS FACILE
            $orderItem->product_id = $r->product_id;
            $orderItem->created_at = $r->created_at;
            $orderItem->updated_at = $r->updated_at;
            $orderItem->save();
            $count++;
        }
        echo $count . ' orders items imported !' . "\n";
    }

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
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function show(OrderItem $orderItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderItem $orderItem)
    {
        //
    }
}
