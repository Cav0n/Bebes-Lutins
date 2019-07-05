<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 03/01/2019
 * Time: 11:48
 */

class Retailer
{
    private $name;
    private $address;
    private $website_url;
    private $image;

    /**
     * Retailer constructor.
     * @param $name
     * @param $address
     * @param $website_url
     * @param $image
     */
    public function __construct(String $name, $address, $website_url, $image)
    {
        $this->name = $name;
        $this->address = $address;
        $this->website_url = $website_url;
        $this->image = $image;
    }

    /**
     * @return String
     */
    public function getName(): String
    {
        return $this->name;
    }

    /**
     * @param String $name
     */
    public function setName(String $name): void
    {
        $this->name = $name;
    }

    /**
     * @return String
     */
    public function getAddress(): String
    {
        return $this->address;
    }

    /**
     * @param String $address
     */
    public function setAddress(String $address): void
    {
        $this->address = $address;
    }

    /**
     * @return String
     */
    public function getWebsiteUrl(): String
    {
        return $this->website_url;
    }

    /**
     * @param String $website_url
     */
    public function setWebsiteUrl(String $website_url): void
    {
        $this->website_url = $website_url;
    }

    /**
     * @return String
     */
    public function getImage(): String
    {
        return $this->image;
    }

    /**
     * @param String $image
     */
    public function setImage(String $image): void
    {
        $this->image = $image;
    }


}