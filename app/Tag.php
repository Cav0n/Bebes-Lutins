<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The products that belongs to the category.
     */
    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    /**
     * The products that belongs to the category.
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
}
