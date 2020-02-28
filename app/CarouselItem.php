<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarouselItem extends Model
{
    public function image()
    {
        return $this->belongsTo('App\Image');
    }
}
