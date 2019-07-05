<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 17/11/2018
 * Time: 16:11
 */

class Address
{
    private $id;
    private $customer;
    private $civility;
    private $surname;
    private $firstname;
    private $address_line;
    private $city;
    private $postal_code;
    private $complement;
    private $company;

    /**
     * Adress constructor.
     * @param $id
     * @param $customer
     * @param $civility
     * @param $surname
     * @param $firstname
     * @param $adress_line
     * @param $city
     * @param $postal_code
     * @param $complement
     * @param $company
     */
    public function __construct(String $id, UserConnected $customer, String $civility, String $surname, String $firstname, String $adress_line, String $city, int $postal_code, $complement, $company)
    {
        $this->id = $id;
        $this->customer = $customer;
        $this->civility = $civility;
        $this->surname = $surname;
        $this->firstname = $firstname;
        $this->address_line = $adress_line;
        $this->city = $city;
        $this->postal_code = $postal_code;
        $this->complement = $complement;
        $this->company = $company;
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
     * @return String
     */
    public function getCivility(): String
    {
        return $this->civility;
    }

    /**
     * @return String
     */
    public function getCivilityString(): String
    {
        switch($this->getCivility()){
            case '1' :
                return "Monsieur ";
                break;

            case '2' :
                return "Madame ";
                break;

            default :
                return '';
                break;
        }
    }

    /**
     * @param String $civility
     */
    public function setCivility(String $civility): void
    {
        $this->civility = $civility;
    }



    /**
     * @return String
     */
    public function getSurname(): String
    {
        return $this->surname;
    }

    /**
     * @param String $surname
     */
    public function setSurname(String $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return String
     */
    public function getFirstname(): String
    {
        return $this->firstname;
    }

    /**
     * @param String $firstname
     */
    public function setFirstname(String $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return String
     */
    public function getAddressLine(): String
    {
        return $this->address_line;
    }

    /**
     * @param String $address_line
     */
    public function setAddressLine(String $address_line): void
    {
        $this->address_line = $address_line;
    }

    /**
     * @return String
     */
    public function getCity(): String
    {
        return $this->city;
    }

    /**
     * @param String $city
     */
    public function setCity(String $city): void
    {
        $this->city = $city;
    }

    /**
     * @return int
     */
    public function getPostalCode(): int
    {
        return $this->postal_code;
    }

    /**
     * @param int $postal_code
     */
    public function setPostalCode(int $postal_code): void
    {
        $this->postal_code = $postal_code;
    }

    /**
     * @return String
     */
    public function getComplement(): String
    {
        return $this->complement;
    }

    /**
     * @param String $complement
     */
    public function setComplement(String $complement): void
    {
        $this->complement = $complement;
    }

    /**
     * @return String
     */
    public function getCompany(): String
    {
        return $this->company;
    }

    /**
     * @param String $company
     */
    public function setCompany(String $company): void
    {
        $this->company = $company;
    }

    public function generateBillingAddressString(): string
    {
        $identity = $this->getFirstname() . " " . $this->getSurname() . "<BR>".$this->getCompany();
        $address = $this->getAddressLine() . "<BR>" . $this->getComplement() ."<BR>" . $this->getPostalCode() . "<BR>" . $this->getCity();
        return "
        <p>$identity</p>
        <p>$address</p> ";
    }

    public function generateShippingAddressString(): string
    {
        if(substr($this->getId(), 0, 15) != 'withdrawal-shop') {
            $identity = $this->getFirstname() . " " . $this->getSurname() . "<BR>" . $this->getCompany();
            $address = $this->getAddressLine() . "<BR>" . $this->getComplement() . "<BR>" . $this->getPostalCode() . "<BR>" . $this->getCity();
            return "
        <p>$identity</p>
        <p>$address</p>";
        } else return "<p>Retrait à l'atelier.</p>";
    }
}