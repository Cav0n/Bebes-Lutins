<?php

namespace App\Http\Controllers;

use App\ShoppingCart;
use App\Voucher;
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
        return view('pages.shopping-cart.payment')->withStep(2)->withShoppingCart($shopping_cart);
    }

    public function validateDelivery(Request $request)
    {
        //dd($request);
        $request->session()->flash('delivery-type', $request['delivery-type']);

        switch($request['delivery-type']){
            case 'new-address':
            //CREATE NEW ADDRESS AND HAD IT TO SHOPPING CART

            AddressController::storeBilling($request);

            if($request['same-shipping-address'] != null){
                AddressController::storeShipping($request);
            }

            break;

            case 'saved-addresses':
            $billing_address_id = $request["billing-address"];
            $shipping_address_id = $request["shipping-address"];

            $same_shipping_address = $request["same-shipping-address"];

            break;

            case 'withdrawal-shop':
            //ADD NEW BILLING ADDRESS AND EMAIL + PHONE
            $email = $request["email"];
            $phone = $request["phone"];
            AddressController::storeBilling($request);

            break;

            default:
            $request->session()->flash('delivery-error', 'Il y a eu une erreur avec le moyen de livraison. Veuillez réessayer.');
            return redirect('/panier/livraison');
            break;
        }

        //return redirect('/panier/paiement');
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
