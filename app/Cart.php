<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
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

    /**
     * ShippingAddress of the cart.
     */
    public function shippingAddress()
    {
        return $this->belongsTo('App\Address');
    }

    /**
     * BillingAddress of the cart.
     */
    public function billingAddress()
    {
        return $this->belongsTo('App\Address');
    }

    /**
     * PromoCode of the cart
     */
    public function promoCode()
    {
        return $this->belongsTo('App\PromoCode');
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
        /** @Todo: Replace "env" usage by database parameters */
        $freeShippingFrom = \App\Setting::getValue('FREE_SHIPPING_FROM', 70.00);

        if($this->totalPrice < $freeShippingFrom) {
            /** @Todo: Replace "env" usage by database parameters */
            $shippingCosts = \App\Setting::getValue('SHIPPING_COSTS', 5.90);
        }

        return $shippingCosts;
    }

    public function getPriceLeftBeforeFreeShippingAttribute()
    {
        /** @Todo: Replace "env" usage by database parameters */
        $freeShippingFrom = \App\Setting::getValue('FREE_SHIPPING_FROM', 70.00);

        return $freeShippingFrom - $this->totalPrice;
    }
}
