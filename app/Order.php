<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function getTotalPriceAttribute()
    {
        $totalPrice = 0.0;

        foreach($this->items as $item){
            $totalPrice += $item->product->price * $item->quantity;
        }

        return $totalPrice;
    }

    public function getStatusI18nAttribute($language = 'FR_fr'): string
    {
        switch($this->status){
            case 'WAIT_PAYMENT':
                return 'En attente de paiement';

            default:
                return 'impossible de trouver le status';
        }
    }

    public function getPaymentMethodI18nAttribute($language = 'FR_fr'): string
   {
        switch($this->paymentMethod){
            case 'CHEQUE':
                return 'chèque';

            case 'CARD':
                return 'carte bancaire';

            default:
                return 'impossible de trouver le moyen de paiement';
        }
   }
}
