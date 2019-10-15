<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCharacteristic extends Model
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
    public function productCharacteristic()
    {
        return $this->belongsTo('App\ProductCharacteristic');
    }

    /**
     * The categories that belongs to the product.
     */
    public function options()
    {
        return $this->hasMany('App\ProductCharacteristic');
    }
}
