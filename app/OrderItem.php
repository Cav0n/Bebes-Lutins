<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
     * Order of the item.
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    /**
     * Product of the item.
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
