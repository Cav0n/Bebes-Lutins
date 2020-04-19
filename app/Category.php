<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class Category extends Model
{
     /**
     * FOR STRING PRIMARY KEY
     */
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

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

    public function getAdminBreadcrumbAttribute()
    {
        $route = route('admin.category.edit', ['category' => $this->id]);
        $breadcrumb = "<a href='$route'>".$this->name."</a>";

        $parent = $this->parent;

        while ($parent != null) {
            $route = route('admin.categories', ['parent' => $parent]);
            $breadcrumb = "<a href='$route'>" . $parent->name . '</a> / ' . $breadcrumb;

            $parent = $parent->parent;
        }

        $route = route('admin.categories');
        $breadcrumb = "/ <a href='$route'>Catégories</a> / " . $breadcrumb;

        return $breadcrumb;
    }
}
