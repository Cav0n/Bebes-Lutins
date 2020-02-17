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

    public function getBreadcrumbAttribute()
    {
        $route = route('product', ['product' => $this]);

        $breadcrumb = $this->name;

        $category = $this->categories->first();

        $breadcrumb =  $category->breadcrumb . " / <a href='$route'>" .$breadcrumb . '</a>';

        return $breadcrumb;
    }
}
