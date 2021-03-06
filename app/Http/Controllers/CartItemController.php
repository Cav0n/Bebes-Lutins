<?php

namespace App\Http\Controllers;

use App\CartItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class CartItemController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CartItemController
    |--------------------------------------------------------------------------
    |
    | This controller handle CartItem model.
    |
    */

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
    public function create(Request $request, \App\Product $product, \App\Cart $cart)
    {
        if ($cartItem = CartItem::where(['cart_id' => $cart->id, 'product_id' => $product->id])->first()){
            $cartItem->quantity += $request->get('quantity');
            $cartItem->save();

            session()->put('shopping_cart', $cart);

            return new JsonResponse(['cartItemID' => $cartItem->id, 'quantity' => $cartItem->quantity], 200);
        }

        $quantity = $request->get('quantity', 1);

        $cartItem = new CartItem();
        $cartItem->quantity = $quantity;
        $cartItem->cart_id = $cart->id;
        $cartItem->product_id = $product->id;
        $cartItem->save();

        session()->put('shopping_cart', $cart);

        return new JsonResponse(['cartItemID' => $cartItem->id, 'quantity' => $cartItem->quantity], 200);
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
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function edit(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $cartItem->quantity = $request->get('quantity');
        $cartItem->save();

        session()->put('shopping_cart', $cartItem->cart);

        return new JsonResponse($cartItem->id, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();
        session()->put('shopping_cart', $cartItem->cart);
        return redirect()->back();
    }
}
