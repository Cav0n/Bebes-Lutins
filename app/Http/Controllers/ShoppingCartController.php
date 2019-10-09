<?php

namespace App\Http\Controllers;

use App\ShoppingCart;
use App\ShoppingCartItem;
use App\Voucher;
use App\Address;
use App\Order;
use App\OrderItem;
use App\Http\Controllers\AddressController;
use Illuminate\Http\Request;
use Auth;

class ShoppingCartController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function show(ShoppingCart $shopping_cart = null, Request $request)
    {
        if($shopping_cart == null){
            $shopping_cart = session('shopping_cart'); 
        }

        return view('pages.shopping-cart.index')->withStep(0)->withShoppingCart($shopping_cart);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function edit(ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingCart $shoppingCart)
    {
        if(isset($request['add_voucher'])){
            $voucher_code = $request['voucher_code'];
            $request->validate([
                'voucher_code' => 'required|exists:voucher',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingCart $shoppingCart)
    {
        //
    }

    public function showDelivery()
    {
        $shopping_cart = session('shopping_cart'); 

        return view('pages.shopping-cart.delivery')->withStep(1)->withShoppingCart($shopping_cart);
    }

    public function validateDelivery(Request $request)
    {
        $shopping_cart = session('shopping_cart');

        $request->session()->flash('delivery-type', $request['delivery-type']); // In case of error keep the delivery type
        $request->session()->flash('same-shipping-address', $request['same-shipping-address']); // In case of error keep the boolean

        switch($request['delivery-type']){
            case 'new-address': // CREATE NEW ADDRESS (BILLING AND SHIPPING if necessary)
                $same_addresses = $request['same-shipping-address'];
                $billing_address_id = AddressController::storeBilling($request);

                if($same_addresses == null){ // If customer want two different addresses (billing & shipping)
                    $shipping_address_id = AddressController::storeShipping($request);
                } else { $shipping_address_id = $billing_address_id; }
                break;

            case 'saved-addresses': // ADD BILLING & SHIPPING ADDRESS IDs
                $billing_address_id = $request["billing-address"];
                $same_shipping_address = $request["same-shipping-address"];

                if($same_shipping_address == null) $shipping_address_id = $request["shipping-address"];
                else $shipping_address_id = $billing_address_id;
                break;

            case 'withdrawal-shop': // CREATE NEW BILLING ADDRESS WITH EMAIL & PHONE
                $request->validate(["email" => "email:filter|required"]);

                $email = $request["email"];
                $phone = $request["phone"];

                $billing_address_id = AddressController::store($request);
                $shipping_address_id = null;
                break;

            default:
            $request->session()->flash('delivery-error', 'Il y a eu une erreur avec le moyen de livraison. Veuillez réessayer.');
            return redirect('/panier/livraison');
            break;
        }

        $shopping_cart->billing_address_id = $billing_address_id;
        $shopping_cart->shipping_address_id = $shipping_address_id;
        $shopping_cart->save();

        $request->session()->put('shopping_cart', $shopping_cart);

        return redirect('/panier/paiement');
    }

    public function showPayment()
    {
        $shopping_cart = session('shopping_cart');
        $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();
        session(['shopping_cart' => $shopping_cart]);
        
        return view('pages.shopping-cart.payment')->withStep(2)->withShoppingCart($shopping_cart);
    }

    public function showCreditCardPayment()
    {
        dd('REDIRIGER VERS CITELIS');
    }

    public function validateChequePayment()
    {
        $shopping_cart = session('shopping_cart');
        $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();

        $shopping_cart->isActive = false;
        $shopping_cart->save();

        $order = new Order();
        $order->id = strtoupper(substr(uniqid(), 0, 10));
        $order->paymentMethod = 2;
        $order->shippingPrice = $shopping_cart->shippingPrice;
        $order->productsPrice = $shopping_cart->productsPrice;
        $order->status = 0;
        $order->user_id = $shopping_cart->user_id;
        $order->voucher_id = $shopping_cart->voucher_id;
        $order->shipping_address_id = $shopping_cart->shipping_address_id;
        $order->billing_address_id = $shopping_cart->billing_address_id;

        $order->save();

        foreach($shopping_cart->items as $item){
            $order_item = new OrderItem();
            $order_item->productName = $item->product->name;
            $order_item->quantity = $item->quantity;
            $order_item->unitPrice = $item->product->price;
            $order_item->product_id = $item->product->id;
            $order_item->order_id = $order->id;
            $order_item->save();
        }

        session(['shopping_cart' => null]);

        return redirect("/merci");
    }

    public function validateCreditCartPayment()
    {

    }

    public function replace(ShoppingCart $shopping_cart)
    {
        $current_shopping_cart = session('shopping_cart');

        foreach($current_shopping_cart->items as $item){
            $item->delete();
        }
        
        foreach($shopping_cart->items as $item){
            $new_item = new ShoppingCartItem();
            $new_item->quantity = $item->quantity;
            $new_item->product_id = $item->product_id;
            $new_item->shopping_cart_id = $current_shopping_cart->id;
            $new_item->save();
        }

        $current_shopping_cart = ShoppingCart::where('id', $current_shopping_cart->id)->first();
        $current_shopping_cart->updateProductsPrice();
        $current_shopping_cart->updateShippingPrice();
        $current_shopping_cart->save();
        session(['shopping_cart' => $current_shopping_cart]);

        return redirect('/panier');
    }
}
