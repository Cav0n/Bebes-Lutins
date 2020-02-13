<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItemCharacteristic extends Model
{
    public function orderItem()
    {
        return $this->belongsTo('App\OrderItem');
    }
}
