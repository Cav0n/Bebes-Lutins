<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 17/11/2018
 * Time: 13:09
 */

class Image
{
    private $name;

    /**
     * Image constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName() : String
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    public function __toString() : String
    {
        return $this->getName();
    }
}