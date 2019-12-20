<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
     * The categories that belongs to the product.
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    /**
     * The categories that belongs to the product.
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    /**
     * 
     */
    public function characteristics()
    {
        return $this->hasMany('App\OrderItemCharacteristic');
    }
}
