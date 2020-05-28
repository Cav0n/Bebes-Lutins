<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class PromoCode
 */
class PromoCode extends Model
{
    const DISCOUNT_TYPE = [
        'PRICE' => '€',
        'PERCENT' => '%',
        'FREE_SHIPPING_COSTS' => 'Frais de port offerts'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'minValidDate' => 'datetime',
        'maxValidDate' => 'datetime',
    ];

    /**
     * Carts of the promo code
     */
    public function carts()
    {
        return $this->hasMany('App\Cart');
    }

    /**
     * Orders of the promo code
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function __toString(): string
    {
        return $this->code;
    }

    public function getIsActiveAttribute($value)
    {
        return $value && $this->minValidDate <= Carbon::now() && $this->maxValidDate >= Carbon::now();
    }

    public function getDiscountTypeMinAttribute()
    {
        return self::DISCOUNT_TYPE[$this->discountType];
    }

    public function getMinCartPriceFormattedAttribute()
    {
        return (null !== $this->minCartPrice) ? number_format($this->minCartPrice, 2, ".", " ") . ' €' : null;
    }

    public function getStatusTagAttribute()
    {
        if ($this->minValidDate > Carbon::now()) {
            return '<span class="badge badge-warning">Programmé</span>';
        }

        if ($this->minValidDate <= Carbon::now() && $this->maxValidDate >= Carbon::now()) {
            return '<span class="badge badge-success">Actif</span>';
        }

        if ($this->maxValidDate < Carbon::now()) {
            return '<span class="badge badge-danger">Périmé</span>';
        }
    }
}
