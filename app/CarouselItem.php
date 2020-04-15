<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class CarouselItem extends Model
{
    public function image()
    {
        return $this->belongsTo('App\Image');
    }
}
