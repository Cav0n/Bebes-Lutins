<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 17/11/2018
 * Time: 15:39
 */

class UserConnected extends User
{
    private $surname;
    private $firstname;
    private $mail;
    private $phone;
    private $privilege;
    private $registration_date;
    private $birthList;
    private $activated;
    private $newsletter;
    private $order_list = array();
    private $address_list = array();
    private $wishlist_id;

    /**
     * UserConnected constructor.
     * @param $id
     * @param $password
     * @param $surname
     * @param $firstname
     * @param $mail
     * @param $phone
     * @param $privilege
     * @param $shopping_cart
     * @param $registration_date
     * @param $birth_list
     * @param $activated
     */
    public function __construct($id, $surname, $firstname, $mail, $phone, $privilege, $registration_date, bool $activated)
    {
        parent::__construct($id);
        $this->surname = $surname;
        $this->firstname = $firstname;
        $this->mail = $mail;
        $this->phone = $phone;
        $this->privilege = $privilege;
        $this->registration_date = $registration_date;
        $this->activated = $activated;
        $this->newsletter = true;
    }

    /**
     * @return String
     */
    public function getId(): String
    {
        return parent::getId();
    }

    /**
     * @param String $id
     */
    public function setId(String $id): void
    {
        parent::setId($id);
    }

    /**
     * @return String
     */
    public function getSurname()
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
    public function getFirstname()
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
    public function getMail(): String
    {
        return $this->mail;
    }

    /**
     * @param String $mail
     */
    public function setMail(String $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return String
     */
    public function getPhone()
    {
        $user_phone = $this->phone;
        if($user_phone == null) $user_phone = "Aucun numéro";
        else {
            if(substr($this->phone, 0, 1) != 0) $user_phone = "0" . $user_phone;
            $user_phone = chunk_split($user_phone, 2, " ");
        }

        return $user_phone;
    }

    /**
     * @param String $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return int
     */
    public function getPrivilege(): int
    {
        return $this->privilege;
    }

    /**
     * @param int $privilege
     */
    public function setPrivilege(int $privilege): void
    {
        $this->privilege = $privilege;
    }

    /**
     * @return ShoppingCart
     */
    public function getShoppingCart(): ShoppingCart
    {
        if(parent::getShoppingCart() != null){
            return parent::getShoppingCart();
        }
        else return $_SESSION['shopping_cart'];
    }

    /**
     * @param ShoppingCart $shopping_cart
     */
    public function setShoppingCart(ShoppingCart $shopping_cart): void
    {
        parent::setShoppingCart($shopping_cart);
    }

    /**
     * @return String
     */
    public function getRegistrationDate(): String
    {
        return $this->registration_date;
    }

    public function getRegistrationDateString(): String
    {
        return date_format(date_create($this->getRegistrationDate()), 'd-m-Y');
    }

    /**
     * @param String $registration_date
     */
    public function setRegistrationDate(String $registration_date): void
    {
        $this->registration_date = $registration_date;
    }

    /**
     * @return array
     */
    public function getOrderList(): array
    {
        return $this->order_list;
    }

    /**
     * @param array $order_list
     */
    public function addOrder(Order $order): void
    {
        $this->order_list[] = $order;
    }

    public function addFirstOrder(Order $order): void
    {
        array_unshift($this->order_list, $order);
    }

    /**
     * @return BirthList
     */
    public function getBirthList(): BirthList
    {
        return $this->birthList;
    }

    /**
     * @param BirthList $birthList
     */
    public function setBirthList(BirthList $birthList): void
    {
        $this->birthList = $birthList;
    }

    /**
     * @return mixed
     */
    public function isActivated() : bool
    {
        return $this->activated;
    }

    /**
     * @param mixed $activated
     */
    public function setActivated(bool $activated): void
    {
        $this->activated = $activated;
    }

    /**
     * @return bool
     */
    public function isNewsletter(): bool
    {
        return $this->newsletter;
    }

    /**
     * @param bool $newsletter
     */
    public function setNewsletter(bool $newsletter): void
    {
        $this->newsletter = $newsletter;
    }

    /**
     * @return array
     */
    public function getAddressList(): array
    {
        return $this->address_list;
    }

    /**
     * @param array $address_list
     */
    public function setAddressList(array $address_list): void
    {
        $this->address_list = $address_list;
    }

    public function addAddress(Address $address){
        $this->address_list[] = $address;
    }

    /**
     * @return string wishlist_id L'identifiant de la liste d'envie de l'utilisateur
     */
    public function getWishListID(): string
    {
        return $this->wishlist_id;
    }

    /**
     * @param string wishlist_id L'identifiant de la liste d'envie de l'utilisateur
     */
    public function setWishListID(string $wishlist_id): void
    {
        $this->wishlist_id = $wishlist_id;
    }
}