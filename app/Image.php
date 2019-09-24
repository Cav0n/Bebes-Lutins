<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The categories that belongs to the product.
     */
    public function products()
    {
        return $this->belongsToMany('App\Products');
    }

    /**
     * The categories that belongs to the product.
     */
    public function categories()
    {
        return $this->belongsToMany('App\Categories');
    }
}
