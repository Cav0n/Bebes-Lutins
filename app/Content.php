<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    /**
     * FooterElement that belong to the content.
     */
    public function footerElement()
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
}
