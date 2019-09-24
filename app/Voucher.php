<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    /**
     * The categories that belongs to the product.
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
