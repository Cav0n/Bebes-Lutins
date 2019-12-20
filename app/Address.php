<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;

    /**
     * The categories that belongs to the product.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }

    public function civilityToString(){
        switch($this->civility){
            case '1':
                return 'Mr';
                break;

            case '2':
                return 'Mme';
                break;

            default:
                return "";
                break;
        }
    }
}
