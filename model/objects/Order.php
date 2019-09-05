<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 16/11/2018
 * Time: 20:13
 */

class Order
{
    private $id;
    private $customer;
    private $shipping_address;
    private $billing_address;
    private $date;
    private $status;
    private $shipping_price;
    private $total_price;
    private $payment_method;
    private $voucher;
    private $birthlistID;
    private $order_items;
    private $cancel;
    private $customer_message;
    private $admin_message;
    private $new;

    /**
     * Order constructor.
     * @param $id
     * @param $customer
     * @param $shipping_address
     * @param $billing_adress
     * @param $date
     * @param $status
     * @param $total_price
     * @param $payment_method
     * @param $voucher
     * @param $birthlist
     */
    public function __construct(String $id, UserConnected $customer, $shipping_address, $billing_adress, String $date, int $status, float $shipping_price, float $total_price, int $payment_method, $voucher, $birthlist_id)
    {
        $this->id = $id;
        $this->customer = $customer;
        $this->shipping_address = $shipping_address;
        $this->billing_address = $billing_adress;
        $this->date = $date;
        $this->status = $status;
        $this->shipping_price = $shipping_price;
        $this->total_price = $total_price;
        $this->payment_method = $payment_method;
        $this->voucher = $voucher;
        $this->birthlistID = $birthlist_id;
        $this->order_items = array();
        $this->cancel = false;
        $this->new = false;
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
     * @return Address
     */
    public function getShippingAddress(): Address
    {
        return $this->shipping_address;
    }

    /**
     * @param Address $shipping_address
     */
    public function setShippingAddress(Address $shipping_address): void
    {
        $this->shipping_address = $shipping_address;
    }

    /**
     * @return Address
     */
    public function getBillingAddress(): Address
    {
        return $this->billing_address;
    }

    /**
     * @param Address $billing_address
     */
    public function setBillingAddress(Address $billing_address): void
    {
        $this->billing_address = $billing_address;
    }

    /**
     * @return String
     */
    public function getDate(): String
    {
        return $this->date;
    }

    public function getDateString(): String{
        return date_format(date_create($this->date), 'd / m / Y');
    }

    public function getDateHoursString(): String{
        return date_format(date_create($this->date), 'G:i');
    }

    /**
     * @param String $date
     */
    public function setDate(String $date): void
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getFriendlyStatus() : String{
        switch($this->getStatus()){
            case 0: 
                return 'en attente de paiement';
                break;

            case 1:
                return 'en cours de traitement ✌️';
                break;

            case 2:
                return 'en cours de livraison 🚚';
                break;

            case 3:
                return 'livrée ✅';
                break;

            case -1:
                return 'annulée 😥';
                break;

            case -2:
                return 'en cours de validation 😬';
                break;

            case -3:
                return 'non débitée';
                break;
        }
    }

    public function getStatusDescription() : String{
        switch($this->getStatus()){
            case 0:
                return 'Dès la réception du paiement de votre commande, nous passerons à la préparation de celle-ci.';
                break;

            case 1: 
                return 'Nous sommes en train de préparer votre commande à l\'atelier,
                encore un petit peu de patience et nous devrions expédier votre colis ! 😉';
                break;

            case 2: 
                return 'Votre commande a quitté notre atelier. Elle est en route, vous devriez la recevoir d\'ici quelques jours.';
                break;

            case 3:
                return 'Nous avons le plaisir de vous annoncer que votre commande est livré ! Toute l\'équipe
                espère que vous serez satisfait de votre achat. <BR>
                Pour toute question ou conseil vous pouvez nous contacter par email à l\'adresse
                <a href="mailto:contact@bebes-lutins.fr">contact@bebes-lutins.fr</a>.<BR>
                <BR>
                À très bientôt sur le site <a href="https://www.bebes-lutins.fr">bebes-lutins.fr</a> 💚';
                break;

            case -1:
                return 'Votre commande à été annulée. Si vous aviez effectué un paiement il vous sera entièrement remboursée.';
                break;

            case -2:
                return 'Nous devons vérifier le paiement de votre commande, cela ne devrait pas prendre longtemps.<BR>
                Pour toute question ou conseil vous pouvez nous contacter par email à l\'adresse
                <a href="mailto:contact@bebes-lutins.fr">contact@bebes-lutins.fr</a>.';
                break;

            case -3:
                return 'Le paiement de votre commande n\'a pas abouti, nous en sommes désolé.<BR>
                Si vous le souhaitez vous pouvez retenter de passer commande sur le site.<BR>
                <BR>
                Vous pouvez nous contacter par email à l\'adresse
                <a href="mailto:contact@bebes-lutins.fr">contact@bebes-lutins.fr</a>, ou par téléphone au
                <a href="tel:0641569165">06 41 56 91 65</a>.';
                break;

            default:
                return "[IL Y A UN PROBLEME AVEC LA DESCRIPTION DE LA COMMANDE]";
                break;
        }
    }

    public function getStatusImage(): String{
        switch ($this->getStatus()){
            case 0:
                return '';
                break;

            case 1: 
                return '<img src="https://www.bebes-lutins.fr/view/assets/images/utils/preparation.jpg" style="display: block; width: 590px;" width="590" border="0" alt="" />';
                break;

            case 2:
                return '<img src="https://www.bebes-lutins.fr/view/assets/images/utils/delivering.jpg" style="display: block; width: 590px;" width="590" border="0" alt="" />';
                break;

            case 3:
                return '<img src="https://www.bebes-lutins.fr/view/assets/images/utils/delivered.jpg" style="display: block; width: 590px;" width="590" border="0" alt="" />';
                break;

            case -1:
                return '<img src="https://www.bebes-lutins.fr/view/assets/images/utils/baby-hide.jpg" style="display: block; width: 590px;" width="590" border="0" alt="" />';
                break;

            default:
                return '';
                break;
        }
    }

    public function statusToString(): String{
        switch ($this->getStatus()){
            case 0:
                return "en attente de paiement";
                break;

            case 1:
                return "en cours de traitement";
                break;

            case 2:
                return "en cours de livraison";
                break;

            case 3:
                return "livrée";
                break;

            case -1:
                return "annulée";
                break;

            case -2:
                return "paiement en cours de validation";
                break;

            case -3:
                return "paiement refusé";
                break;

            case 10:
                return "LISTE DE NAISSANCE : En attente de paiement";
                break;

            case 11:
                return "LISTE DE NAISSANCE : Payé";
                break;

            case -11:
                return "LISTE DE NAISSANCE : Annulée";
                break;

            default:
                return "[IL Y A UN PROBLEME AVEC L'ETAT DE LA COMMANDE]";
        }
    }

    /**
     * @return float
     */
    public function getShippingPrice(): float
    {
        if($this->getVoucher() != null){
            if($this->getVoucher()->getType() == 3) return 0;
        }
        return $this->shipping_price;
    }

    /**
     * @param float $shipping_price
     */
    public function setShippingPrice(float $shipping_price): void
    {
        $this->shipping_price = $shipping_price;
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->total_price;
    }

    /**
     * @param float $total_price
     */
    public function setTotalPrice(float $total_price): void
    {
        $this->total_price = $total_price;
    }

    /**
     * @return int
     */
    public function getPaymentMethod(): int
    {
        return $this->payment_method;
    }

    public function getPaymentMethodString(): String
    {
        switch ($this->getPaymentMethod()){
            case "1":
                return "carte bancaire";
                break;

            case "2":
                return "chèque bancaire";
                break;

            default:
                return "inconnu";
                break;
        }
    }


    public function getPaymentMethodMin(): String
    {
        switch ($this->getPaymentMethod()){
            case "1":
                return "CB";
                break;

            case "2":
                return "CHQ";
                break;

            default:
                return "inconnu";
                break;
        }
    }
    /**
     * @param int $payment_method
     */
    public function setPaymentMethod(int $payment_method): void
    {
        $this->payment_method = $payment_method;
    }

    /**
     * @return Voucher
     */
    public function getVoucher()
    {
        return $this->voucher;
    }

    /**
     * @param Voucher $voucher
     */
    public function setVoucher(Voucher $voucher): void
    {
        $this->voucher = $voucher;
    }

    /**
     * @return string $birthlist_id
     */
    public function getBirthlistID()
    {
        return $this->birthlistID;
    }

    /**
     * @param string $birthlist_id
     */
    public function setBirthlistID(String $birthlist_id): void
    {
        $this->birthlistID = $birthlist_id;
    }

    /**
     * @return array
     */
    public function getOrderItems(): array
    {
        return $this->order_items;
    }

    /**
     * @param array $order_items
     */
    public function setOrderItems(array $order_items): void
    {
        $this->order_items = $order_items;
    }

    public function addOrderItem(OrderItem $order_item): void
    {
        $this->order_items[] = $order_item;
    }

    public function getCancel(): bool
    {
        return $this->cancel;
    }

    public function setCancel(bool $cancel)
    {
        $this->cancel = $cancel;
    }

    public function getCustomerMessage()
    {
        return $this->customer_message;
    }

    public function setCustomerMessage(string $customer_message)
    {
        $this->customer_message = $customer_message;
    }

    /**
     * @return mixed
     */
    public function getAdminMessage()
    {
        return $this->admin_message;
    }

    /**
     * @param mixed $admin_message
     */
    public function setAdminMessage($admin_message): void
    {
        $this->admin_message = $admin_message;
    }

    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->new;
    }

    /**
     * @param bool $new
     */
    public function setNew(bool $new): void
    {
        $this->new = $new;
    }

    public function getPriceAfterDiscount() : float{
        if($this->getVoucher() != null){
            $total_price = $this->getTotalPrice();
            $new_price = $total_price;

            switch ($this->getVoucher()->getType()){
                case 1: //%
                    $new_price = $total_price - ($total_price * ($this->getVoucher()->getDiscount() / 100)) + $this->getShippingPrice();
                    break;

                case 2: //€
                    $new_price = $total_price - $this->getVoucher()->getDiscount() + $this->getShippingPrice();
                    break;

                case 3: //Free shipping price
                    $new_shipping_price = 0.00;
                    $new_price = $this->getTotalPrice() + $new_shipping_price;
                    break;
            }
            return $new_price;
        }
        return $this->getTotalPrice() + $this->getShippingPrice();
    }
}