<?php

namespace App\Http\Controllers;

use App\ShoppingCart;
use App\Voucher;
use App\Address;
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

    public function showDelivery()
    {
        $shopping_cart = session('shopping_cart'); 

        return view('pages.shopping-cart.delivery')->withStep(1)->withShoppingCart($shopping_cart);
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

    
}
