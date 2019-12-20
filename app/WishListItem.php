<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishListItem extends Model
{
    /**
     * The categories that belongs to the product.
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    /**
     * The categories that belongs to the product.
     */
    public function wishList()
    {
        return $this->belongsTo('App\WishList');
    }
}
