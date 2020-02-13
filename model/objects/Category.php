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
    private $tags;
    private $private;

    /**
     * Category constructor.
     * @param $name
     * @param $parent
     * @param $image
     */
    public function __construct($name, $parent, ImageCategory $image, $description, $rank, $tags, $private)
    {
        $this->name = $name;
        $this->parent = $parent;
        $this->image = $image;
        $this->description = $description;
        $this->rank = $rank;
        $this->tags = $tags;
        $this->private = $private;
    }

    public function getID(): String
    {
        $id = $this->getName();
        $id = UtilsModel::replace_accent_and_keep_space($id);
        $id = str_replace(' ', '-', $id); // Replaces all spaces with hyphens.
        $id = preg_replace('/[^A-Za-z0-9\-]/', '', $id); // Removes special chars.

        return preg_replace('/-+/', '-', $id); // Replaces multiple hyphens with single one.
    }

    /**
     * @return String nameForURL
     */
    public function getNameForURL(): String
    {
        return str_replace("’", "_", str_replace(" ", "=",UtilsModel::replace_accent($this->getName())));
    }

    /**
     * @return String name
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
     * @return string parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param string $parent
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

    /**
     * @return string Category's tags.
     */
    public function getTags(): string
    {
        if($this->tags == null) return '';
        else return $this->tags;
    }

    /**
     * @param string $tags New category's tags.
     */
    public function setTags(string $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return bool If the category is private return true, else return false.
     */
    public function getPrivate(): bool
    {
        return $this->private;
    }

    /**
     * @param bool Set if category is private or not (true or false).
     */
    public function setPrivate(bool $private): void
    {
        $this->private = $private;
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