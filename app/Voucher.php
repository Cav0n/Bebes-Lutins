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
}
