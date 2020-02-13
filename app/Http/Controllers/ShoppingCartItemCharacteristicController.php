<?php

namespace App\Http\Controllers;

use App\ShoppingCartItemCharacteristic;
use Illuminate\Http\Request;

class ShoppingCartItemCharacteristicController extends Controller
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
    public static function store(Request $request)
    {
        $characteristics = $request['characteristics'];
        foreach ($characteristics as $name=>$option){
            $characteristic = new ShoppingCartItemCharacteristic();
            $characteristic->name = $name;
            $characteristic->selectedOptionName = $option;
            $characteristic->shopping_cart_item_id = $request['item_id'];
            $characteristic->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShoppingCartItemCharacteristic  $shoppingCartItemCharacteristic
     * @return \Illuminate\Http\Response
     */
    public function show(ShoppingCartItemCharacteristic $shoppingCartItemCharacteristic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShoppingCartItemCharacteristic  $shoppingCartItemCharacteristic
     * @return \Illuminate\Http\Response
     */
    public function edit(ShoppingCartItemCharacteristic $shoppingCartItemCharacteristic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShoppingCartItemCharacteristic  $shoppingCartItemCharacteristic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingCartItemCharacteristic $shoppingCartItemCharacteristic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShoppingCartItemCharacteristic  $shoppingCartItemCharacteristic
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingCartItemCharacteristic $shoppingCartItemCharacteristic)
    {
        //
    }
}
