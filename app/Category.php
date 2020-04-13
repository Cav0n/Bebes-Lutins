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

    public function childs()
    {
        return $this->hasMany('App\Category', 'parentId');
    }

    public function images()
    {
        return $this->belongsToMany('App\Image');
    }

    public function getBreadcrumbAttribute()
    {
        $route = route('category', ['category' => $this]);
        $breadcrumb = "<a href='$route'>" . $this->name . "</a>";

        $parent = $this->parent;

        while ($parent != null){
            $route = route('category', ['category' => $parent]);
            $breadcrumb = "<a href='$route'>" . $parent->name . '</a> / ' . $breadcrumb;

            $parent = $parent->parent;
        }

        $breadcrumb = "/ <a href='/'>Accueil</a> / " . $breadcrumb;

        return $breadcrumb;
    }
}
