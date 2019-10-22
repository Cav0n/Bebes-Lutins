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
        $message = array();

        $shopping_cart_id = $request['shopping_cart_id'];
        $product_id = $request['product_id'];
        $product = Product::where('id', $product_id)->first();
        $quantity = $request['quantity'];

        $already_exists = false;

        $message[] = 'YES';

        if(ShoppingCartItem::where('shopping_cart_id', $shopping_cart_id)->where('product_id', $product_id)->exists()){
            $message[] = 'ITEM EXISTS';
            foreach(ShoppingCartItem::where('shopping_cart_id', $shopping_cart_id)->where('product_id', $product_id)->get() as $item){
                $already_exists = true;
                $characteristic_nb = count($item->characteristics);
                

                if($characteristic_nb > 0){
                    foreach($request['characteristics'] as $name=>$option){
                        $r_characteristics[] = $option;
                    }
                    foreach($item->characteristics as $characteristic){
                        $message[] = $characteristic->selectedOptionName;
                        if(! in_array($characteristic->selectedOptionName, $r_characteristics)){
                            $already_exists = false;
                            $message[] = $characteristic->selectedOptionName . ' - ' . $r_characteristics[0];
                        }
                        if(in_array($characteristic->selectedOptionName, $r_characteristics)){
                            $already_exists = true;
                            $message[] = $characteristic->selectedOptionName . ' - ' . $r_characteristics[0];
                            break;
                        }
                    }
                } else if($request['characteristics'] != null){
                    $already_exists = false;
                    break;
                } else {
                    $already_exists = true;
                    break;
                }
                if($already_exists){ 
                    $selected_item = $item;
                    break;
                }
                
            }
        } else $already_exists = false;

        if(! $already_exists){
            $existing_quantity = 0;
            foreach(ShoppingCartItem::where('shopping_cart_id', $shopping_cart_id)->where('product_id', $product_id)->get() as $item){
                $existing_quantity += $item->quantity;
            }
            $item = new ShoppingCartItem();
            $item->quantity = $quantity - 1;
            $item->shopping_cart_id = $shopping_cart_id;
            $item->product_id = $product_id;
            $item->save();
            if(($item->quantity + $existing_quantity) > $item->product->stock) {
                $item->quantity = $item->product->stock;
                $item->save();
            }
            $request['item_id'] = $item->id;
            if($request['characteristics'] != null) ShoppingCartItemCharacteristicController::store($request);
        } else {
            $quantity--;
            $existing_quantity = 0;
            foreach(ShoppingCartItem::where('shopping_cart_id', $shopping_cart_id)->where('product_id', $product_id)->get() as $item){
                $existing_quantity += $item->quantity;
            }
            $selected_item->quantity = $selected_item->quantity + $quantity;
            if($existing_quantity > $selected_item->product->stock) $selected_item->quantity = $selected_item->product->stock - $existing_quantity;

            $selected_item->save();
        }

        $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();
        $shopping_cart->updateProductsPrice();
        $shopping_cart->updateShippingPrice();
        $shopping_cart->save();
        session(['shopping_cart' => $shopping_cart]);

        $response = ['item_id' => $item->id, 'characteristics' => $item->characteristics, 'message' => $message];
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
        $request->validate([
            'quantity' => 'numeric|max:100|required',
        ]);

        $stock = $shoppingCartItem->product->stock;
        $new_quantity = $request['quantity'];

        $existing_quantity = 0;
        foreach(ShoppingCartItem::where('shopping_cart_id', $shoppingCartItem->shoppingCart->id)->where('product_id', $shoppingCartItem->product->id)->get() as $item){
            $existing_quantity += $item->quantity;
        }

        if(isset($request['add'])){
            if($stock >= $existing_quantity + $new_quantity){
                $shoppingCartItem->quantity = $shoppingCartItem->quantity + $new_quantity;
            } else $shoppingCartItem->quantity = $stock - $existing_quantity;
        } else {
            if($stock >= $existing_quantity + $new_quantity){
                $shoppingCartItem->quantity = $new_quantity;
            } else  $shoppingCartItem->quantity = $stock - $existing_quantity;
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
