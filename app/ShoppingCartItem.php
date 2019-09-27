<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingCartItem extends Model
{
    /**
     * The categories that belongs to the product.
     */
    public function shoppingCart()
    {
        return $this->belongsTo('App\ShoppingCart');
    }
}
