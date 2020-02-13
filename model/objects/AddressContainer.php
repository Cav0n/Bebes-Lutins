<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 03/12/2018
 * Time: 09:45
 */

class AddressContainer
{
    private $address;

    /**
     * AddressContainer constructor.
     * @param $address
     */
    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }
}