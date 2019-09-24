<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The categories that belongs to the product.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function orders(){
        return $this->belongsToMany('App\Order');
    }
}
