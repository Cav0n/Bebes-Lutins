<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * FOR STRING PRIMARY KEY
     */
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Categories that belong to the product.
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    /**
     * Images that belong to the product.
     */
    public function images()
    {
        return $this->belongsToMany('App\Image');
    }

    /**
     * CartItems that belong to the product.
     */
    public function items()
    {
        return $this->hasMany('App\CartItem');
    }
}
