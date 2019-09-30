<?php

namespace App\Http\Controllers;

use App\ShoppingCartItem;
use App\ShoppingCart;
use Illuminate\Http\Request;

class ShoppingCartItemController extends Controller
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
        $response = array();
        
        $shopping_cart_id = $request['shopping_cart_id'];
        
        if(ShoppingCart::where('id', $shopping_cart_id)->exists() == 0){
            $response['message'] = $shopping_cart_id . " ";
            ShoppingCartController::createNew();
            $shopping_cart_id = session('shopping_cart')->id;
            $response['message'] = $response['message'] . $shopping_cart_id;
        }

        $item = new ShoppingCartItem();
        $item->quantity = $request['quantity'];
        $item->shopping_cart_id = $shopping_cart_id;
        $item->product_id = $request['product_id'];
        $item->save();
        
        echo json_encode($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShoppingCartItem  $shoppingCartItem
     * @return \Illuminate\Http\Response
     */
    public function show(ShoppingCartItem $shoppingCartItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShoppingCartItem  $shoppingCartItem
     * @return \Illuminate\Http\Response
     */
    public function edit(ShoppingCartItem $shoppingCartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShoppingCartItem  $shoppingCartItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingCartItem $shoppingCartItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShoppingCartItem  $shoppingCartItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingCartItem $shoppingCartItem)
    {
        //
    }
}
