<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 17/11/2018
 * Time: 15:48
 */

class BirthList
{
    private $id;
    private $user;
    private $creation_date;
    private $father_name;
    private $mother_name;
    private $message;
    private $shipping_address;
    private $step;
    private $items;

    /**
     * BirthList constructor.
     * @param $id
     * @param $user
     * @param $creation_date
     */
    public function __construct(string $id, UserConnected $user, DateTime $creation_date)
    {
        $this->id = $id;
        $this->user = $user;
        $this->creation_date = $creation_date;
        $this->items = array();
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
    public function getUser(): UserConnected
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser(UserConnected $user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getCreationDate(): DateTime
    {
        return $this->creation_date;
    }

    /**
     * @param mixed $creation_date
     */
    public function setCreationDate(DateTime $creation_date): void
    {
        $this->creation_date = $creation_date;
    }

    /**
     * @return mixed
     */
    public function getFatherName() : string
    {
        return $this->father_name;
    }

    /**
     * @param mixed $father_name
     */
    public function setFatherName(string $father_name): void
    {
        $this->father_name = $father_name;
    }

    /**
     * @return mixed
     */
    public function getMotherName(): string
    {
        return $this->mother_name;
    }

    /**
     * @param mixed $mother_name
     */
    public function setMotherName(string $mother_name): void
    {
         $this->mother_name = $mother_name;
    }

    /**
     * @return mixed
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getShippingAddress(): Address
    {
        return $this->shipping_address;
    }

    /**
     * @param mixed $shipping_address
     */
    public function setShippingAddress(Address $shipping_address): void
    {
        $this->shipping_address = $shipping_address;
    }

    /**
     * @return mixed
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @param mixed $step
     */
    public function setStep($step): void
    {
        $this->step = $step;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function addItem(BirthListItem $item)
    {
        $this->items[] = $item;
    }
}