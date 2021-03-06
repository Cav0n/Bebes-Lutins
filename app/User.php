<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'phone', 'email', 'password', 'wantNewsletter'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'isAdmin',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Carts of the user.
     */
    public function carts()
    {
        return $this->hasMany('App\Cart');
    }

    /**
     * Orders of the user.
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    /**
     * Addresses of the user.
     */
    public function addresses()
    {
        return $this->hasMany('App\Address');
    }

    public function reviews()
    {
        return $this->belongsToMany('App\Review');
    }

    public function getFirstnameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getLastnameAttribute($value)
    {
        return mb_strtoupper($value);
    }
}
