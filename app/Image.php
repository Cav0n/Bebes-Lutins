<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * Products that belong to the product.
     */
    public function products()
    {
        return $this->belongsToMany('App\Product');
    }
}
