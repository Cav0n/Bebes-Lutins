<?php


class Product
{
    private $id;
    private $id_copy;
    private $name;
    private $ceo_name;
    private $price;
    private $stock;
    private $description;
    private $ceo_description;
    private $category;
    private $creation_date;
    private $image;
    private $number_of_review;
    private $number_of_stars;
    private $reference;
    private $tags;
    private $hide;
    private $average_mark;

    /**
     * Product constructor.
     * @param $id
     * @param $id_copy
     * @param $name
     * @param $price
     * @param $stock
     * @param $description_big
     * @param $description_small
     * @param $category
     * @param $creation_date
     * @param $image
     * @param $number_of_review
     * @param $number_of_stars
     * @param $custom_id
     */
    public function __construct(String $id, String $id_copy, String $name, $ceo_name, float $price, int $stock, String $description, $ceo_description, $category, $creation_date, ImageProduct $image, int $number_of_review, int $number_of_stars, $reference, $tags, bool $hide)
    {
        $this->id = $id;
        $this->id_copy = $id_copy;
        $this->name = $name;
        $this->ceo_name = $ceo_name;
        $this->price = $price;
        $this->stock = $stock;
        $this->description = $description;
        $this->ceo_description = $ceo_description;
        $this->category = $category;
        $this->creation_date = $creation_date;
        $this->image = $image;
        $this->number_of_review = $number_of_review;
        $this->number_of_stars = $number_of_stars;
        $this->reference = $reference;
        $this->tags = $tags;
        $this->hide = $hide;
    }

    public function getID2(): String
    {
        $id = $this->getName();
        $id = UtilsModel::replace_accent_and_keep_space($id);
        $id = str_replace(' ', '-', $id); // Replaces all spaces with hyphens.
        $id = preg_replace('/[^A-Za-z0-9\-]/', '', $id); // Removes special chars.
        
        return preg_replace('/-+/', '-', $id); // Replaces multiple hyphens with single one.
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
     * @return String
     */
    public function getIdCopy(): String
    {
        return $this->id_copy;
    }

    /**
     * @param String $id_copy
     */
    public function setIdCopy(String $id_copy): void
    {
        $this->id_copy = $id_copy;
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
    public function getCeoName()
    {
        return $this->ceo_name;
    }

    /**
     * @param mixed $ceo_name
     */
    public function setCeoName($ceo_name): void
    {
        $this->ceo_name = $ceo_name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @return String
     */
    public function getDescription(): String
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
     * @return String
     */
    public function getCeoDescription(): String
    {
        return $this->ceo_description;
    }

    /**
     * @param String $ceo_description
     */
    public function setCeoDescription(String $ceo_description): void
    {
        $this->ceo_description = $ceo_description;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * @param mixed $creation_date
     */
    public function setCreationDate($creation_date): void
    {
        $this->creation_date = $creation_date;
    }

    /**
     * @return ImageProduct
     */
    public function getImage(): ImageProduct
    {
        return $this->image;
    }

    /**
     * @param ImageProduct $image
     */
    public function setImage(ImageProduct $image): void
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getNumberOfReview(): int
    {
        return $this->number_of_review;
    }

    /**
     * @param int $number_of_review
     */
    public function setNumberOfReview(int $number_of_review): void
    {
        $this->number_of_review = $number_of_review;
    }

    /**
     * @return int
     */
    public function getNumberOfStars(): int
    {
        return $this->number_of_stars;
    }

    /**
     * @param int $number_of_stars
     */
    public function setNumberOfStars(int $number_of_stars): void
    {
        $this->number_of_stars = $number_of_stars;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     */
    public function setReference($reference): void
    {
        $this->reference = $reference;
    }

    function multiexplode ($delimiters,$string) {
    
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }

    public function getTagsArray()
    {
        return $this->multiexplode(array(',', ';'), $this->tags);
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return mixed
     */
    public function getHide() : bool
    {
        return $this->hide;
    }

    /**
     * @param mixed $hide
     */
    public function setHide(bool $hide): void
    {
        $this->hide = $hide;
    }

    /**
     * @return mixed
     */
    public function getAverageMark() : float
    {
        $this->generateAverageMark();
        if($this->average_mark != null)
            return $this->average_mark;
        else return 0;
    }

    /**
     * @param mixed $average_mark
     */
    public function setAverageMark($average_mark)
    {
        $this->average_mark = $average_mark;
    }

    public function generateAverageMark()
    {
        if($this->getNumberOfReview() > 0){
            $this->average_mark = $this->getNumberOfStars() / $this->getNumberOfReview();
        }
    }
}