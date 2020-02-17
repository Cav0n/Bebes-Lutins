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

    public function parent()
    {
        return $this->belongsTo('App\Category', 'parentId');
    }

    public function child()
    {
        return $this->hasMany('App\Category', 'parentId');
    }

    public function getBreadcrumbAttribute()
    {
        $breadcrumb = $this->name;

        $parent = $this->parent;

        while ($parent != null){
            $route = route('category', ['category' => $parent]);
            $breadcrumb = "<a href='$route'>" . $parent->name . '</a> / ' . $breadcrumb;

            $parent = $parent->parent;
        }

        $breadcrumb = "<a href='/'>Accueil</a> / " . $breadcrumb;

        return $breadcrumb;
    }
}
