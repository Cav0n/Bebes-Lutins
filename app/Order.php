<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;

    /**
     * The categories that belongs to the product.
     */
    public function voucher()
    {
        return $this->belongsTo('App\Voucher');
    }

    /**
     * The categories that belongs to the product.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * The categories that belongs to the product.
     */
    public function order_items()
    {
        return $this->hasMany('App\OrderItem');
    }

    /**
     * The categories that belongs to the product.
     */
    public function shipping_address()
    {
        return $this->belongsTo('App\Address');
    }

    /**
     * The categories that belongs to the product.
     */
    public function billing_address()
    {
        return $this->belongsTo('App\Address');
    }

    public function statusToBadge()
    {
        switch($this->status){
            case '0':
                return '<span class="badge badge-warning">En attente de paiement</span>';
                break;

            case '1':
                return '<span class="badge badge-info">En cours de traitement</span>';
                break;

            case '2':
                return '<span class="badge badge-info">En cours de livraison</span>';
                break;

            case '22':
                return '<span class="badge badge-success">Prête à l\'atelier</span>';
                break;

            case '3':
                return '<span class="badge badge-success">Livrée</span>';
                break;

            case '33':
                return '<span class="badge badge-success">Participation enregistrée</span>';
                break;

            case '-1':
                return '<span class="badge badge-danger">Annulée</span>';
                break;

            case '-2':
                return '<span class="badge badge-warning">Vérification bancaire</span>';
                break;

            case '-3':
                return '<span class="badge badge-danger">Paiement refusé</span>';
                break;

            default:
                return '<span class="badge badge-danger">Problème de mise à jour</span>';
                break;
        }    
    }
}
