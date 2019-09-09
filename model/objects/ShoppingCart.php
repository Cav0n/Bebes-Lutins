<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 20:09
 */

class ShoppingCart
{
    private $id;
    private $customer;
    private $total_price;
    private $voucher;
    private $shopping_cart_items = array();
    private $customer_message;

    /**
     * ShoppingCart constructor.
     * @param $id
     * @param $id_customer
     * @param $total_price
     * @param $voucher
     */
    public function __construct(String $id, float $total_price, $shopping_cart_items)
    {
        $this->id = $id;
        $this->total_price = $total_price;
        $this->shopping_cart_items = $shopping_cart_items;
    }

    /**
     * @return String
     */
    public function getId(): String
    {
        return $this->id;
    }

    /**
     * @param String $id
     */
    public function setId(String $id): void
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getCustomer(): User
    {
        return $this->customer;
    }

    /**
     * @param User $customer
     */
    public function setCustomer(User $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->total_price;
    }

    /**
     * @param float $total_price
     */
    public function setTotalPrice(float $total_price): void
    {
        $this->total_price = $total_price;
    }

    /**
     * @return Voucher
     */
    public function getVoucher()
    {
        return $this->voucher;
    }

    /**
     * @param Voucher $voucher
     */
    public function setVoucher($voucher): void
    {
        $this->voucher = $voucher;
    }

    public function getShoppingCartItems()
    {
        return $this->shopping_cart_items;
    }

    public function setMessage($message){
        $this->customer_message = $message;
    }

    public function getMessage(){
        return $this->customer_message;
    }

    public function setShoppingCartItems(array $shopping_cart_items){
        $this->shopping_cart_items = $shopping_cart_items;
    }

    public function addShoppingCartItems(ShoppingCartItem $shopping_cart_item){
        $already_in_itemslist = false;
        foreach ($this->shopping_cart_items as $item){
            if($item->getProduct()->getName() == $shopping_cart_item->getProduct()->getName()){
                $item->setQuantity($item->getQuantity() + $shopping_cart_item->getQuantity()) ;
                $already_in_itemslist = true;
                break;
            }
        }
        if(! $already_in_itemslist) $this->shopping_cart_items[] = $shopping_cart_item;
        $this->total_price += $shopping_cart_item->getPrice() * $shopping_cart_item->getQuantity();
    }
}