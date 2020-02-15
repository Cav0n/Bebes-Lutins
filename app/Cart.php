<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * User that has the cart.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * CartItems that belong to the cart.
     */
    public function items()
    {
        return $this->hasMany('App\CartItem');
    }

    public function getTotalQuantityAttribute()
    {
        $totalQuantity = 0;

        foreach($this->items as $item){
            $totalQuantity += $item->quantity;
        }

        return $totalQuantity;
    }

    public function getTotalPriceAttribute()
    {
        $totalPrice = 0.0;

        foreach($this->items as $item){
            $totalPrice += $item->product->price * $item->quantity;
        }

        return $totalPrice;
    }

    public function getShippingCostsAttribute()
    {
        $shippingCosts = 0.00;
        $freeShippingFrom = env('FREE_SHIPPING_FROM', 70.00);

        if($this->totalPrice < $freeShippingFrom) {
            $shippingCosts = env('SHIPPING_COSTS', 5.90);
        }

        return $shippingCosts;
    }
}
