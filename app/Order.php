<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;

    /**
     * The categories that belongs to the product.
     */
    public function voucher()
    {
        return $this->belongsTo('App\Voucher');
    }

    /**
     * The categories that belongs to the product.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * The categories that belongs to the product.
     */
    public function order_items()
    {
        return $this->hasMany('App\OrderItem');
    }

    /**
     * The categories that belongs to the product.
     */
    public function shipping_address()
    {
        return $this->belongsTo('App\Address');
    }

    /**
     * The categories that belongs to the product.
     */
    public function billing_address()
    {
        return $this->belongsTo('App\Address');
    }
}
