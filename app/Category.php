<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
     /**
     * FOR STRING PRIMARY KEY
     */
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Products that belong to the category.
     */
    public function products()
    {
        return $this->belongsToMany('App\Product');
    }
}
