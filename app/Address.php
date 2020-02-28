<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function getFirstnameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getLastnameAttribute($value)
    {
        return mb_strtoupper($value);
    }

    public function getIdentityAttribute()
    {
        return $this->civility . ' ' . $this->firstname . ' ' . $this->lastname;
    }
}
