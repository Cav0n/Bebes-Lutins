<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    
    /**
     * The categories that belongs to the product.
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function shopping_carts(){
        return $this->hasMany('App\ShoppingCart');
    }

    public function products(){
        return $this->belongsToMany('App\Product');
    }

    public function categories(){
        return $this->belongsToMany('App\Category');
    }

    public function typeToString(){
        switch($this->discountType){
            case '1':
            return "%";
            break;

            case '2':
            return "€";
            break;

            case '3':
            return 'Frais de port';
            break;

            default:
            return 'inconnu';
            break;
        }
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'dateFirst',
        'dateLast',
    ];
}
