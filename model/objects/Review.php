<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 08/03/2019
 * Time: 09:01
 */

class Review
{
    private $id;
    private $product;
    private $customer;
    private $customer_name;
    private $mark;
    private $text;
    private $has_reponse;
    private $date;
    private $declined;

    /**
     * Review constructor.
     * @param $id
     * @param $product
     * @param $customer
     * @param $customer_name
     * @param $mark
     * @param $text
     * @param $has_reponse
     * @param $date
     * @param $declined
     */
    public function __construct(string $id, Product $product, UserConnected $customer, string $customer_name, int $mark, string $text, bool $has_reponse, string $date, bool$declined)
    {
        $this->id = $id;
        $this->product = $product;
        $this->customer = $customer;
        $this->customer_name = $customer_name;
        $this->mark = $mark;
        $this->text = $text;
        $this->has_reponse = $has_reponse;
        $this->date = $date;
        $this->declined = $declined;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return UserConnected
     */
    public function getCustomer(): UserConnected
    {
        return $this->customer;
    }

    /**
     * @param UserConnected $customer
     */
    public function setCustomer(UserConnected $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return string
     */
    public function getCustomerName(): string
    {
        return $this->customer_name;
    }

    /**
     * @param string $customer_name
     */
    public function setCustomerName(string $customer_name): void
    {
        $this->customer_name = $customer_name;
    }

    /**
     * @return int
     */
    public function getMark(): int
    {
        return $this->mark;
    }

    /**
     * @param int $mark
     */
    public function setMark(int $mark): void
    {
        $this->mark = $mark;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return bool
     */
    public function isHasReponse(): bool
    {
        return $this->has_reponse;
    }

    /**
     * @param bool $has_reponse
     */
    public function setHasReponse(bool $has_reponse): void
    {
        $this->has_reponse = $has_reponse;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return bool
     */
    public function isDeclined(): bool
    {
        return $this->declined;
    }

    /**
     * @param bool $declined
     */
    public function setDeclined(bool $declined): void
    {
        $this->declined = $declined;
    }


}