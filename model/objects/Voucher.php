<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 17/11/2018
 * Time: 15:22
 */

class Voucher
{
    private $id;
    private $name;
    private $discount;
    private $type;
    private $date_beginning;
    private $date_end;
    private $number_of_usage;

    /**
     * Voucher constructor.
     * @param $name
     * @param $discount
     * @param $type
     * @param $date_beginning
     * @param $date_end
     * @param $number_of_usage
     */
    public function __construct(String $id, String $name, float $discount, String $type, String $date_beginning, String $date_end, int $number_of_usage)
    {
        $this->id = $id;
        $this->name = $name;
        $this->discount = $discount;
        $this->type = $type;
        $this->date_beginning = $date_beginning;
        $this->date_end = $date_end;
        $this->number_of_usage = $number_of_usage;
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
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     */
    public function setDiscount(float $discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return String
     */
    public function getType(): String
    {
        return $this->type;
    }

    /**
     * @param String $type
     */
    public function setType(String $type): void
    {
        $this->type = $type;
    }

    public function getTypeString(): String
    {
        switch ($this->type){
            case 1:
                return '%';
                break;

            case 2:
                return '€';
                break;

            case 3:
                return 'frais de port offert';
                break;

            default :
                return 'inconnu';
                break;
        }
    }

    /**
     * @return String
     */
    public function getDateBeginning(): String
    {
        return $this->date_beginning;
    }

    public function getDateBeginningString() : String
    {
        return date_format(date_create($this->date_beginning), 'd-m-Y');
    }

    /**
     * @param String $date_beginning
     */
    public function setDateBeginning(String $date_beginning): void
    {
        $this->date_beginning = $date_beginning;
    }

    /**
     * @return String
     */
    public function getDateEnd(): String
    {
        return $this->date_end;
    }

    public function getDateEndString() : String
    {
        return date_format(date_create($this->date_end), 'd-m-Y');
    }

    /**
     * @param String $date_end
     */
    public function setDateEnd(String $date_end): void
    {
        $this->date_end = $date_end;
    }

    /**
     * @return int
     */
    public function getNumberOfUsage(): int
    {
        return $this->number_of_usage;
    }

    /**
     * @param int $number_of_usage
     */
    public function setNumberOfUsage(int $number_of_usage): void
    {
        $this->number_of_usage = $number_of_usage;
    }

    public function getDiscountAndTypeString() : String{
        if($this->discount != null)
            return $this->discount ." ". $this->getTypeString();
        else{
            return $this->getTypeString();
        }
    }

    public function isExpire() : bool{
        $beginning_date = date_create($this->getDateBeginning());
        $end_date = date_create($this->getDateEnd());
        $today_date=date_create(date('Y-m-d'));

        if (intval(date_diff($end_date, $today_date)->format("%R%a")) > 0){
            return true;
        } else return false;
    }
}