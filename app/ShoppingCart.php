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

    public function billing_address()
    {
        return $this->hasOne('App\Address', 'id', 'billing_address_id');
    }

    public function shipping_address()
    {
        return $this->hasOne('App\Address', 'id', 'shipping_address_id');
    }

    public function updateProductsPrice()
    {
        $total_price = 0.0;
        foreach($this->items as $item){
            $total_price += $item->product->price * $item->quantity;
        }

        if($this->voucher != null){
            switch($this->voucher->discountType){
                case '1': $total_price = $total_price - ($total_price * $this->voucher->discountValue) / 100;break;
                case '2': $total_price = ($total_price - $this->voucher->discountValue); break;
            }
        }

        $this->productsPrice = $total_price;
    }

    public function updateShippingPrice()
    {
        $this->shippingPrice = 0.0;

        if($this->productsPrice < 70){
            if($this->voucher != null && ($this->voucher->discountType == 3)){
                $this->shippingPrice = 0.00;
            } else $this->shippingPrice = 5.90;
        }
    }

    public function calculatePricesAndQuantities() : array
    {
        $total_price = 0.00;
        $total_quantity = 0;
        $shipping_price = 5.90;
        $total = 0.00;
        $price_before_free_shipping = 70.00;

        if(count($this->items) > 0){
            foreach ($this->items as $item) {
                $total_price += $item->product->price * $item->quantity;

                $total_quantity += $item->quantity;
            }
            $price_before_free_shipping -= $total_price;
        }

        if($total_price >= 70){
            $shipping_price = 0;
            $price_before_free_shipping = 0.00;
        }

        $result = ['products_price' => $total_price, 'shipping_price' => $shipping_price, 'total_quantity' => $total_quantity];
        return $result;
    }
}
