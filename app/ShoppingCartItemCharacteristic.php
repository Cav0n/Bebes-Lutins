<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingCartItemCharacteristic extends Model
{
    public function shoppingCartItem()
    {
        return $this->belongsTo('App\ShoppingCartItem');
    }
}
