<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 17/11/2018
 * Time: 15:50
 */

class BirthListItem
{
    private $id;
    private $birthlist_id;
    private $product;
    private $quantity;
    private $payed;
    private $customer;
    private $billing_address;
    private $buying_date;

    /**
     * BirthListItem constructor.
     * @param $id
     * @param $birthlist_id
     * @param $product
     * @param $quantity
     */
    public function __construct(string $id, string $birthlist_id, Product $product, int $quantity)
    {
        $this->id = $id;
        $this->birthlist_id = $birthlist_id;
        $this->product = $product;
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getBirthlistId(): string
    {
        return $this->birthlist_id;
    }

    /**
     * @param mixed $birthlist_id
     */
    public function setBirthlistId(string $birthlist_id): void
    {
        $this->birthlist_id = $birthlist_id;
    }

    /**
     * @return mixed
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getPayed() : bool
    {
        return $this->payed;
    }

    /**
     * @param mixed $payed
     */
    public function setPayed(bool $payed): void
    {
        $this->payed = $payed;
    }

    /**
     * @return mixed
     */
    public function getCustomer(): UserConnected
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer(UserConnected $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return mixed
     */
    public function getBillingAddress(): Address
    {
        return $this->billing_address;
    }

    /**
     * @param mixed $billing_address
     */
    public function setBillingAddress(Address $billing_address): void
    {
        $this->billing_address = $billing_address;
    }

    /**
     * @return mixed
     */
    public function getBuyingDate() : DateTime
    {
        return $this->buying_date;
    }

    /**
     * @param mixed $buying_date
     */
    public function setBuyingDate(DateTime $buying_date): void
    {
        $this->buying_date = $buying_date;
    }
}