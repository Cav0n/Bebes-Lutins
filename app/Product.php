<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
    public function product()
    {
        return $this->hasMany('App\OrderItem');
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
}
