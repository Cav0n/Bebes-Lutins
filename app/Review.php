<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class Review extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function getColorAttribute()
    {
        if ($this->mark > 2.5) {
            return 'green';
        }

        if ($this->mark == 2.5) {
            return 'orange';
        }

        return 'red';
    }
}
