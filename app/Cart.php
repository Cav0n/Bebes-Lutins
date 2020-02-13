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
}
