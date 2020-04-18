<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class FooterElement extends Model
{
    /**
     * Contents that belong to the footer element.
     */
    public function contents()
    {
        return $this->belongsToMany('App\Content');
    }
}
