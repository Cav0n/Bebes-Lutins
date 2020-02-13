<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 17/11/2018
 * Time: 13:06
 */

class ImageProduct extends Image
{
    private $thumbnails = array();

    /**
     * ImageProduct constructor.
     * @param $thumbnails
     * @param $name
     */
    public function __construct($thumbnails, String $name)
    {
        parent::__construct($name);
    }

    /**
     * @return mixed
     */
    public function getName() : String
    {
        return parent::getName();
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        parent::setName($name);
    }

    /**
     * @return array
     */
    public function getThumbnails()
    {
        return $this->thumbnails;
    }

    /**
     * @param array $thumbnails
     */
    public function setThumbnails(array $thumbnails): void
    {
        $this->thumbnails = $thumbnails;
    }

    public function addThumbnail(Image $image): void
    {
        $this->thumbnails[] = $image;
    }
}