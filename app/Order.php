<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class Order extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id'
    ];

    /**
     * Items of the order.
     */
    public function items()
    {
        return $this->hasMany('App\OrderItem');
    }

    /**
     * Shipping address of the order.
     */
    public function shippingAddress()
    {
        return $this->belongsTo('App\Address');
    }

    /**
     * Billing address of the order.
     */
    public function billingAddress()
    {
        return $this->belongsTo('App\Address');
    }

    /**
     * PromoCode of the order
     */
    public function promoCode()
    {
        return $this->belongsTo('App\PromoCode');
    }

    public function getTotalPriceAttribute()
    {
        $totalPrice = 0.0;

        foreach($this->items as $item){
            $totalPrice += $item->unitPrice * $item->quantity;
        }

        return $totalPrice;
    }

    public function getStatusI18nAttribute($language = 'FR_fr'): string
    {
        return trans('order.status.' . $this->status);
    }

    public function getStatusColorAttribute(): string
    {
        switch($this->status) {
            case 'WAITING_PAYMENT':
                return '#ffff17';
            break;

            case 'DELIVERED':
                return '#60eb4b';
            break;

            case 'WITHDRAWAL':
                return '#60eb4b';
            break;

            case 'REGISTERED_PARTICIPATION':
                return '#60eb4b';
            break;

            case 'CANCELED':
                return '#ff2929';
            break;

            case 'REFUSED_PAYMENT':
                return '#ff2929';
            break;

            default:
                return 'white';
        }
    }

    public function getStatusTagAttribute()
    {
        return '<span class="badge badge-pill" style="background-color: '.$this->statusColor .'">'.ucfirst($this->statusI18n) .'</span>';
    }

    public function getPaymentMethodI18nAttribute($language = 'FR_fr'): string
    {
        return trans('order.payment_method.' . $this->paymentMethod);
    }
}
