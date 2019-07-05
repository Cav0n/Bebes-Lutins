<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 20:05
 */

class Category
{
    private $name;
    private $parent;
    private $image;
    private $description;
    private $rank;

    /**
     * Category constructor.
     * @param $name
     * @param $parent
     * @param $image
     */
    public function __construct(String $name, $parent, ImageCategory $image, $description, int $rank)
    {
        $this->name = $name;
        $this->parent = $parent;
        $this->image = $image;
        $this->description = $description;
        $this->rank = $rank;
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
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return ImageCategory
     */
    public function getImage(): ImageCategory
    {
        return $this->image;
    }

    /**
     * @param ImageCategory $image
     */
    public function setImage(ImageCategory $image): void
    {
        $this->image = $image;
    }

    /**
     * @return String
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param String $description
     */
    public function setDescription(String $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * @param int $rank
     */
    public function setRank(int $rank): void
    {
        $this->rank = $rank;
    }

    public function toString(): String {
        if($this->getParent() != 'none' && $this->getParent() != null){
            return $this->getParent() . " - " . $this->getName();
        }
        else return $this->getName();
    }

    public function compareFullName(Category $a, Category $b){
        return strcmp($a->toString(), $b->toString());
    }
}