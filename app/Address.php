<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
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
        return ucfirst($this->getCivilityI18nAttribute()) . ' ' . ucfirst($this->firstname) . ' ' . mb_strtoupper($this->lastname);
    }

    public function getCivilityI18nAttribute($language = 'FR_fr'): string
    {
        return trans('address.civility.' . $this->civility);
    }

    public function getMinCivilityI18nAttribute($language = 'FR_fr'): string
    {
        return trans('address.civility.min.' . $this->civility);
    }
}
