<?php

namespace App\Http\Controllers;

use App\ShoppingCartItem;
use App\ShoppingCart;
use App\Product;
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
        $shopping_cart = session('shopping_cart');

        $shopping_cart_id = $request['shopping_cart_id'];
        $product_id = $request['product_id'];
        $product = Product::where('id', $product_id)->first();
        $quantity = $request['quantity'];

        if($product->stock > 0){
            if(ShoppingCartItem::where('shopping_cart_id', $shopping_cart_id)->where('product_id', $product_id)->exists()){
                $item = ShoppingCartItem::where('shopping_cart_id', $shopping_cart_id)->where('product_id', $product_id)->first();
                if($product->stock > ($item->quantity + $quantity)){
                    $item->quantity = $item->quantity + $quantity;
                    $item->save();
                }
            } else {
                $item = new ShoppingCartItem();
                $item->quantity = $quantity;
                $item->shopping_cart_id = $shopping_cart_id;
                $item->product_id = $product_id;
                $item->save();
            }
        }

        if(isset($item)){
            $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();
            $shopping_cart->updateProductsPrice();
            $shopping_cart->updateShippingPrice();
            $shopping_cart->save();
            session(['shopping_cart' => $shopping_cart]);

            $response = ['item_id' => $item->id];
            echo json_encode($response);
        }
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
        $request->validate([
            'quantity' => 'numeric|max:100|required',
        ]);
        
        if(isset($request['add'])){
            if($shoppingCartItem->$product->stock > ($shoppingCartItem->quantity + $request['quantity'])){
                $shoppingCartItem->quantity = $shoppingCartItem->quantity + $request['quantity'];
            } else $shoppingCartItem->quantity = $shoppingCartItem->$product->stock;
        } else {
            if($shoppingCartItem->$product->stock > $request['quantity']){
                $shoppingCartItem->quantity = $request['quantity'];
            } else $shoppingCartItem->quantity = $shoppingCartItem->$product->stock;
        }

        $shoppingCartItem->save();

        $shopping_cart = session('shopping_cart');

        $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();
        $shopping_cart->updateProductsPrice();
        $shopping_cart->updateShippingPrice();
        $shopping_cart->save();

        session(['shopping_cart' => $shopping_cart]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShoppingCartItem  $shoppingCartItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingCartItem $shoppingCartItem)
    {
        $shoppingCartItem->delete();

        $shopping_cart = session('shopping_cart');

        $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();
        $shopping_cart->updateProductsPrice();
        $shopping_cart->updateShippingPrice();
        $shopping_cart->save();
        session(['shopping_cart' => $shopping_cart]);
    }
}
