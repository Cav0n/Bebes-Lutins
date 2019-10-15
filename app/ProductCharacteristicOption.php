<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCharacteristicOption extends Model
{
    /**
     * The categories that belongs to the product.
     */
    public function characteristic()
    {
        return $this->belongsTo('App\ProductCharacteristic');
    }
}
