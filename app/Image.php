<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class Image extends Model
{
    /**
     * Products that belong to the product.
     */
    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
}
