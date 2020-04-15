<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class CartItem extends Model
{
    /**
     * Cart that has the item.
     */
    public function cart()
    {
        return $this->belongsTo('App\Cart');
    }

    /**
     * Product that has the item.
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
