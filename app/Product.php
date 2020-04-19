<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
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
        return $this->belongsToMany('App\Image')->withPivot('rank');
    }

    /**
     * CartItems that belong to the product.
     */
    public function items()
    {
        return $this->hasMany('App\CartItem');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review')->orderBy('created_at', 'desc');
    }

    public function getPriceAttribute($value)
    {
        if ($this->promoPrice) {
            return $this->promoPrice;
        }

        return $value;
    }

    public function getPriceWithoutPromoAttribute()
    {
        return $this->attributes['price'];
    }

    public function getIsInPromoAttribute()
    {
        return (null !== $this->promoPrice);
    }

    public function getBreadcrumbAttribute()
    {
        $route = route('product', ['product' => $this]);

        $breadcrumb = $this->name;

        $category = $this->categories->first();

        $breadcrumb =  $category->breadcrumb . " / <a href='$route'>" .$breadcrumb . '</a>';

        return $breadcrumb;
    }

    public function getGlobalMarkAttribute()
    {
        $totalMark = 0;
        $numberOfReviews = 0;

        foreach($this->reviews as $review) {
            $totalMark += $review->mark;
            $numberOfReviews++;
        }

        if (0 >= $numberOfReviews) {
            return 0;
        }

        return $totalMark / $numberOfReviews;
    }
}
