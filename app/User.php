<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $primaryKey = 'id';
    public $incrementing = false;

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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['birthdate'];

    public function shopping_carts()
    {
        return $this->hasMany('App\ShoppingCart');
    }

    public function hasActiveShoppingCarts()
    {
        return $this->hasMany('App\ShoppingCart')->where('isActive', 1)->exists();
    }

    public function active_shopping_cart()
    {
        return $this->hasMany('App\ShoppingCart')->where('isActive', 1)->take(1);
    }

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
        return $this->hasMany('App\Address')->where('isDeleted', 0)->orderBy('street', 'asc');
    }

    /**
     * The categories that belongs to the product.
     */
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    /**
     * Get the phone record associated with the user.
     */
    public function wishlist()
    {
        return $this->hasOne('App\WishList');
    }
}
