<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * Items of the order.
     */
    public function items()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function getTotalPriceAttribute()
    {
        $totalPrice = 0.0;

        foreach($this->items as $item){
            $totalPrice += $item->product->price * $item->quantity;
        }

        return $totalPrice;
    }
}
