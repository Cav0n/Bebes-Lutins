<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    
    /**
     * The categories that belongs to the product.
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    /**
     * The categories that belongs to the product.
     */
    public function images()
    {
        return $this->belongsToMany('App\Image');
    }

    /**
     * The products that belongs to the category.
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    /**
     * 
     */
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    /**
     * 
     */
    public function shoppingCartItems()
    {
        return $this->hasMany('App\ShoppingCartItem');
    }

    /**
     * The categories that belongs to the product.
     */
    public function orderItems()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function characteristics()
    {
        return $this->hasMany('App\ProductCharacteristic');
    }
}
