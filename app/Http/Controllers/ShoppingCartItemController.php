<?php

namespace App\Http\Controllers;

use App\ShoppingCartItem;
use App\ShoppingCart;
use App\Product;
use Illuminate\Http\Request;

class ShoppingCartItemController extends Controller
{
    public function checkIfProductAlreadyInShoppingCart(Request $request)
    {
        $shopping_cart = session('shopping_cart');
        $product_id = $request['product_id'];


        if(ShoppingCartItem::where('shopping_cart_id', $shopping_cart->id)->where('product_id', $product_id)->where('name', $request['name'])->exists()){
            $shoppingCartItem = ShoppingCartItem::where('shopping_cart_id', $shopping_cart->id)->where('product_id', $product_id)->where('name', $request['name'])->first();
            $this->update($request, $shoppingCartItem);
        } else {
            $this->store($request);
        }
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
        $shopping_cart = session('shopping_cart');
        $product = Product::where('id', $request['product_id'])->first();
        $quantity = $request['quantity'];

        $item = new ShoppingCartItem();
        $item->name = $request['name'];
        $item->quantity = $quantity;
        $item->shopping_cart_id = $shopping_cart->id;
        $item->product_id = $product->id;
        $item->save();

        if($request['characteristics'] != null) ShoppingCartItemCharacteristicController::store($request);

        $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();
        $shopping_cart->updateProductsPrice();
        $shopping_cart->updateShippingPrice();
        $shopping_cart->save();
        
        session(['shopping_cart' => $shopping_cart]);

        $response['message'] = "Produit ajouté avec succés.";
        $response['code'] = 200;

        return response()->json($response, $response['code']);
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

        $shopping_cart = session('shopping_cart');
        $new_quantity = $request['quantity'];
        $stock = $shoppingCartItem->product->stock;
        
        $shoppingCartItem->quantity += $new_quantity;
        if($shoppingCartItem->quantity > $stock) $shoppingCartItem->quantity = $stock; 
        $shoppingCartItem->save();
        
        $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();
        $shopping_cart->updateProductsPrice();
        $shopping_cart->updateShippingPrice();
        $shopping_cart->save();

        session(['shopping_cart' => $shopping_cart]);
    }

    public function updateQuantityOnly(Request $request, ShoppingCartItem $shoppingCartItem)
    {
        $new_quantity = $request['quantity'];

        $shoppingCartItem->quantity = $new_quantity;

        $shoppingCartItem->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShoppingCartItem  $shoppingCartItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingCartItem $shoppingCartItem)
    {
        foreach($shoppingCartItem->characteristics as $characteristic){
            $characteristic->delete();
        }
        $shoppingCartItem->delete();

        $shopping_cart = session('shopping_cart');

        $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();
        $shopping_cart->updateProductsPrice();
        $shopping_cart->updateShippingPrice();
        $shopping_cart->save();
        session(['shopping_cart' => $shopping_cart]);
    }
}
