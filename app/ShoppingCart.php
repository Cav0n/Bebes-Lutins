<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ShoppingCart extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;

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
    public function items()
    {
        return $this->hasMany('App\ShoppingCartItem');
    }

    public function voucher()
    {
        return $this->belongsTo('App\Voucher');
    }
}
