<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    /**
     * FooterElement that belong to the content.
     */
    public function footerElements()
    {
        return $this->belongsToMany('App\FooterElement');
    }

    /**
     * Sections that belong to the content.
     */
    public function sections()
    {
        return $this->hasMany('App\ContentSection');
    }

    public function getTypeI18nAttribute()
    {
        return trans('content.type.' . $this->type);
    }
}
