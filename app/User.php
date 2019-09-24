<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'phone', 'password', 'wantNewsletter'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'isAdmin', 'privileges'
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
     * The categories that belongs to the product.
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    /**
     * The categories that belongs to the product.
     */
    public function addresses()
    {
        return $this->hasMany('App\Address');
    }

    /**
     * The categories that belongs to the product.
     */
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }
}
