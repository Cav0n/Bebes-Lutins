<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    
    /**
     * The categories that belongs to the product.
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function shopping_carts(){
        return $this->hasMany('App\ShoppingCart');
    }

    public function products(){
        return $this->belongsToMany('App\Product');
    }

    public function categories(){
        return $this->belongsToMany('App\Category');
    }

    public function typeToString(){
        switch($this->discountType){
            case '1':
            return "%";
            break;

            case '2':
            return "€";
            break;

            case '3':
            return 'Frais de port';
            break;

            default:
            return 'inconnu';
            break;
        }
    }

    public function description(){
        switch($this->discountType){
            case '1':
            $description =  '-' . $this->discountValue . '% sur votre commande';
            if($this->minimalPrice > 0){
                 $description = $description . ' dès ' . number_format($this->minimalPrice, 2) . '€ d\'achat'; }
            if(count($this->products) > 0){
                $description = $description . ', sur certains produits'; }
            if(count($this->categories) > 0){
                $description = $description . ', sur certaines catégories';}
            $description = $description . '.';
            break;

            case '2':
            $description =  '-' . $this->discountValue . '€ sur votre commande';
            if($this->minimalPrice > 0){
                 $description = $description . ' dès ' . number_format($this->minimalPrice, 2) . '€ d\'achat'; }
            if(count($this->products) > 0){
                $description = $description . ', sur certains produits'; }
            if(count($this->categories) > 0){
                $description = $description . ', sur certaines catégories';}
            $description = $description . '.';
            break;

            case '3':
            $description =  'Frais de port offerts sur votre commande';
            if($this->minimalPrice > 0){
                 $description = $description . ' dès ' . number_format($this->minimalPrice, 2) . '€ d\'achat'; }
            if(count($this->products) > 0){
                $description = $description . ', sur certains produits'; }
            if(count($this->categories) > 0){
                $description = $description . ', sur certaines catégories';}
            $description = $description . '.';
            break;

            default:
            $description = "Impossible de récupérer les informations de la réduction.";
            break;
        }

        return $description;
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'dateFirst',
        'dateLast',
    ];
}
