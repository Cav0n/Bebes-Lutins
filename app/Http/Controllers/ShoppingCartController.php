<?php

namespace App\Http\Controllers;

use Carbon;
use Auth;
use App\ShoppingCart;
use App\ShoppingCartItem;
use App\Voucher;
use App\Address;
use App\Order;
use App\OrderItem;
use App\OrderItemCharacteristic;
use App\Mail\OrderCreated;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only(
            'showDelivery',
            'validateDelivery',
            'showPayment',
            'showCreditCardPayment',
            'validateChequePayment',
            'validateCreditCartPayment');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function show(ShoppingCart $shopping_cart = null, Request $request)
    {
        $shopping_cart = session('shopping_cart');
        $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();
        $shopping_cart->updateProductsPrice();
        $shopping_cart->updateShippingPrice();
        $shopping_cart->save();
        session(['shopping_cart' => $shopping_cart]);

        if(session('shopping_cart_infos') != null){
            $shopping_cart_infos = session('shopping_cart_infos');
            session(['shopping_cart_infos' => null]);
        } else $shopping_cart_infos = null;

        return view('pages.shopping-cart.index')->withStep(0)->withShoppingCart($shopping_cart)->withShoppingCartInfos($shopping_cart_infos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function edit(ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingCart $shoppingCart)
    {
        if(isset($request['add_voucher'])){
            $voucher_code = $request['voucher_code'];
            $request->validate([
                'voucher_code' => 'required|exists:voucher',
            ]);
        }

        if(isset($request['add_message'])){
            $shopping_cart = ShoppingCart::where('id', $shoppingCart->id)->first();
            $shopping_cart->customerMessage = $request['message'];
            $shopping_cart->save();

            $data = ['message' => $request['message']];
            header('Content-type: application/json');
            echo json_encode( $data, JSON_PRETTY_PRINT);
        }
        header('Content-type: application/json');
        echo json_encode( ['test'=>"ca marche pas mec"], JSON_PRETTY_PRINT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingCart $shoppingCart)
    {
        //
    }

    public function showDelivery()
    {
        $shopping_cart = session('shopping_cart'); 

        return view('pages.shopping-cart.delivery')->withStep(1)->withShoppingCart($shopping_cart);
    }

    public function validateDelivery(Request $request)
    {
        $shopping_cart = session('shopping_cart');

        $request->session()->flash('delivery-type', $request['delivery-type']); // In case of error keep the delivery type
        $request->session()->flash('same-shipping-address', $request['same-shipping-address']); // In case of error keep the boolean

        switch($request['delivery-type']){
            case 'new-address': // CREATE NEW ADDRESS (BILLING AND SHIPPING if necessary)
                $same_addresses = $request['same-shipping-address'];
                $billing_address_id = AddressController::storeBilling($request);

                if($same_addresses == null){ // If customer want two different addresses (billing & shipping)
                    $shipping_address_id = AddressController::storeShipping($request);
                } else { $shipping_address_id = $billing_address_id; }
                break;

            case 'saved-addresses': // ADD BILLING & SHIPPING ADDRESS IDs
                $billing_address_id = $request["billing-address"];
                $same_shipping_address = $request["same-shipping-address"];

                if($same_shipping_address == null) $shipping_address_id = $request["shipping-address"];
                else $shipping_address_id = $billing_address_id;
                break;

            case 'withdrawal-shop': // CREATE NEW BILLING ADDRESS WITH EMAIL & PHONE
                $request->validate(["email" => "email:filter|required"]);

                $email = $request["email"];
                $phone = $request["phone"];

                $billing_address_id = AddressController::store($request);
                $shipping_address_id = null;
                break;

            default:
            $request->session()->flash('delivery-error', 'Il y a eu une erreur avec le moyen de livraison. Veuillez réessayer.');
            return redirect('/panier/livraison');
            break;
        }

        $shopping_cart->billing_address_id = $billing_address_id;
        $shopping_cart->shipping_address_id = $shipping_address_id;
        $shopping_cart->save();

        $request->session()->put('shopping_cart', $shopping_cart);

        return redirect('/panier/paiement');
    }

    public function showPayment()
    {
        $shopping_cart = session('shopping_cart');
        $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();
        session(['shopping_cart' => $shopping_cart]);
        
        return view('pages.shopping-cart.payment')->withStep(2)->withShoppingCart($shopping_cart);
    }

    public function showCreditCardPayment()
    {
        $array = array();

        $shopping_cart = session('shopping_cart');
        $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();

        $order = new Order();
        $order->id = strtoupper(substr(uniqid(), 0, 10));
        $order->paymentMethod = 2;
        $order->shippingPrice = $shopping_cart->shippingPrice;
        $order->productsPrice = $shopping_cart->productsPrice;
        $order->status = 0;
        $order->user_id = $shopping_cart->user_id;
        $order->voucher_id = $shopping_cart->voucher_id;
        $order->customerMessage = $shopping_cart->customerMessage;
        $order->shipping_address_id = $shopping_cart->shipping_address_id;
        $order->billing_address_id = $shopping_cart->billing_address_id;

        $order->save();

        foreach($shopping_cart->items as $item){
            $item->product->stock = $item->product->stock - $item->quantity;
            $item->product->save();
            $order_item = new OrderItem();
            $order_item->productName = $item->product->name;
            $order_item->quantity = $item->quantity;
            $order_item->unitPrice = $item->product->price;
            $order_item->product_id = $item->product->id;
            $order_item->order_id = $order->id;
            $order_item->save();

            foreach($item->characteristics as $characteristic){
                $item_characteristic = new OrderItemCharacteristic();
                $item_characteristic->name = $characteristic->name;
                $item_characteristic->selectedOptionName = $characteristic->selectedOptionName;
                $item_characteristic->order_item_id = $order_item->id;
                $item_characteristic->save();
            }
        }

        $order_id = $order->id;
        $total_price = $order->shippingPrice + $order->productsPrice;

        $payline = new \App\Payment\paylineSDK(env("MERCHANT_ID"), env("ACCESS_KEY"), env("PROXY_HOST"), env("PROXY_PORT"), env("PROXY_LOGIN"), env("PROXY_PASSWORD"), env("ENVIRONMENT"));
        $payline->returnURL = env("RETURN_URL").'/'. $order_id .'/';
        $payline->cancelURL = env("CANCEL_URL").'/'. $order_id .'/';
        $payline->notificationURL = env("NOTIFICATION_URL").'/'. $order_id .'/';
        $payline->customPaymentPageCode = env("CUSTOM_PAYMENT_PAGE_CODE");

//VERSION
        $array['version'] = env("WS_VERSION");

// PAYMENT
        $array['payment']['amount'] = $total_price * 100;
        $array['payment']['currency'] = 978;
        $array['payment']['action'] = env("PAYMENT_ACTION");
        $array['payment']['mode'] = env("PAYMENT_MODE");

// ORDER
        $array['order']['ref'] = $order_id;
        $array['order']['amount'] = $total_price * 100;
        $array['order']['currency'] = 978;

// CONTRACT NUMBERS
        $array['payment']['contractNumber'] = env("CONTRACT_NUMBER");
        $contracts = explode(";",env("CONTRACT_NUMBER_LIST"));
        $array['contracts'] = $contracts;
        $secondContracts = explode(";",env("SECOND_CONTRACT_NUMBER_LIST"));
        $array['secondContracts'] = $secondContracts;

// EXECUTE
        $response = $payline->doWebPayment($array);


        if(isset($response) && $response['result']['code'] == '00000'){
            if( !headers_sent() ){
                header("location:".$response['redirectURL']);
            }else{
                ?>
                <script type="text/javascript">
                    document.location.href="<?php echo $response['redirectURL'];?>";
                </script>
                Vous allez être rediriger vers la <a href="<?php echo $response['redirectURL'] ?>">page de paiement</a>.
                <?php
            }
            die();
        }elseif(isset($response)) {
            echo "Une erreur s'est produite : ".$response['result']['code']. ' '.$response['result']['longMessage']." 
            <BR>Vous pouvez nous contacter à l'adresse suivante : contact@bebes-lutins.fr";
        }
    }

    public function validateChequePayment()
    {
        $shopping_cart = session('shopping_cart');
        $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();

        $shopping_cart->isActive = false;
        $shopping_cart->save();

        $order = new Order();
        $order->id = strtoupper(substr(uniqid(), 0, 10));
        $order->paymentMethod = 2;
        $order->shippingPrice = $shopping_cart->shippingPrice;
        $order->productsPrice = $shopping_cart->productsPrice;
        $order->status = 0;
        $order->user_id = $shopping_cart->user_id;
        $order->voucher_id = $shopping_cart->voucher_id;
        $order->customerMessage = $shopping_cart->customerMessage;
        $order->shipping_address_id = $shopping_cart->shipping_address_id;
        $order->billing_address_id = $shopping_cart->billing_address_id;

        $order->save();

        foreach($shopping_cart->items as $item){
            $item->product->stock = $item->product->stock - $item->quantity;
            $item->product->save();
            $order_item = new OrderItem();
            $order_item->productName = $item->product->name;
            $order_item->quantity = $item->quantity;
            $order_item->unitPrice = $item->product->price;
            $order_item->product_id = $item->product->id;
            $order_item->order_id = $order->id;
            $order_item->save();

            foreach($item->characteristics as $characteristic){
                $item_characteristic = new OrderItemCharacteristic();
                $item_characteristic->name = $characteristic->name;
                $item_characteristic->selectedOptionName = $characteristic->selectedOptionName;
                $item_characteristic->order_item_id = $order_item->id;
                $item_characteristic->save();
            }
        }

        $shopping_cart->isActive = 0;
        $shopping_cart->save();

        session(['shopping_cart' => null]);

        Mail::to($order->user->email)->send(new \App\Mail\OrderCreated($order));

        return redirect("/merci");
    }

    public function validateCreditCartPayment()
    {

    }

    public function replace(ShoppingCart $shopping_cart)
    {
        $current_shopping_cart = session('shopping_cart');

        foreach($current_shopping_cart->items as $item){
            $item->delete();
        }
        
        foreach($shopping_cart->items as $item){
            $new_item = new ShoppingCartItem();
            $new_item->quantity = $item->quantity;
            $new_item->product_id = $item->product_id;
            $new_item->shopping_cart_id = $current_shopping_cart->id;
            $new_item->save();
        }

        $current_shopping_cart = ShoppingCart::where('id', $current_shopping_cart->id)->first();
        $current_shopping_cart->updateProductsPrice();
        $current_shopping_cart->updateShippingPrice();
        $current_shopping_cart->save();
        session(['shopping_cart' => $current_shopping_cart]);

        return redirect('/panier');
    }

    public function addVoucher(Request $request)
    {
        header('Content-type: application/json');
        
        $code = $request['code'];
        
        // CODE EXISTS ?
        if(!Voucher::where('code', $code)->exists()){
            $response_array['status'] = 'error'; 
            $response_array['message'] = "Le code n'existe pas."; 
            echo json_encode($response_array, JSON_PRETTY_PRINT);
            return;
        }

        $voucher = Voucher::where('code', $code)->first();
        $shopping_cart = session('shopping_cart');

        // FIRST DATE IS IN THE FUTUR ?
        if($voucher->dateFirst > Carbon\Carbon::now()){
            $response_array['status'] = 'error'; 
            $response_array['message'] = "Le code n'existe pas."; 
            echo json_encode($response_array, JSON_PRETTY_PRINT);
            return;
        }

        // LAST DATE IS IN THE PAST ?
        if($voucher->dateLast < Carbon\Carbon::now()){
            $response_array['status'] = 'error'; 
            $response_array['message'] = "Le code n'est plus disponible."; 
            echo json_encode($response_array, JSON_PRETTY_PRINT);
            return;
        }

        // SHOPPING CART MINIMAL PRICE IS OK ?
        if($shopping_cart->productsPrice < $voucher->minimalPrice){
            $response_array['status'] = 'error'; 
            $response_array['message'] = "Votre panier doit atteindre " . number_format($voucher->minimalPrice, 2) . "€."; 
            echo json_encode($response_array, JSON_PRETTY_PRINT);
            return;
        }

        $usage_number = Order::where('voucher_id', $voucher->id)->where('user_id', $shopping_cart->user_id)->count();

        // NUMBER OF USAGE FOR CURRENT CUSTOMER
        if($usage_number >= $voucher->maxUsage){
            $response_array['status'] = 'error'; 
            $response_array['message'] = "Vous avez atteint la limite d'utilisation de ce code."; 
            echo json_encode($response_array, JSON_PRETTY_PRINT);
            return;
        }

        // IF DISCOUNT TYPE IS €
        if($voucher->discountType == 2){
            // PRODUCTS ID OF THE VOUCHER (AUTHORIZED / FORBIDDEN)
            $productid_voucher_list = array();
            foreach($voucher->products as $product){
                $productid_voucher_list[] = $product->id;
            }
            
            // CATEGORIES ID OF THE VOUCHER (AUTHORIZED / FORBIDDEN)
            $categoriesid_voucher_list = array();
            foreach($voucher->categories as $category){
                $categoriesid_voucher_list[] = $category->id;
            }
            
            switch($voucher->availability){
                case 'allProducts': // AVAILABLE ON ALL PRODUCTS EXCEPTS ...
                foreach($shopping_cart->items as $item){
                    $item->hasReduction = 1;
                    if(in_array($item->product->id, $productid_voucher_list)){
                        $item->hasReduction = 0;
                    }
                    $item->save();
                }
                break;

                case 'certainProducts': // AVAILABLE ON ONLY CERTAIN PRODUCTS
                foreach($shopping_cart->items as $item){
                    $item->hasReduction = 0;
                    if(in_array($item->product->id, $productid_voucher_list)){
                        $item->hasReduction = 1;
                    }
                    $item->save();
                }
                break;

                case 'certainCategories': // AVAILABLE ON CERTAIN CATEGORIES
                foreach($shopping_cart->items as $item){
                    $item->hasRedution = 0;
                    $item->save();
                    foreach($item->product->categories as $category){
                        while($category->parent != null){
                            if(in_array($category->id, $categoriesid_voucher_list)){
                                $item->hasRedution = 1;
                                $item->save();
                                break;
                            } else $category = $category->parent;
                        }
                    }
                }
                break;

                case 'allCategories': // AVAILABLE ON ALL CATEGORIES EXCEPTS...
                foreach($shopping_cart->items as $item){
                    $item->hasRedution = 1;
                    $item->save();
                    foreach($item->product->categories as $category){
                        while($category->parent != null){
                            if(in_array($category->id, $categoriesid_voucher_list)){
                                $item->hasRedution = 0;
                                $item->save();
                                break;
                            } else $category = $category->parent;
                        }
                    }
                }
                break;
            }
        }

        // IF VOUCHER IS "FREE SHIPPING" AND SHOPPING CART PRICE > 70€
        // THEN VOUCHER IS NOT NEEDED BECAUSE SHIPPING IS ALREADY FREE
        if($voucher->discountType == 3 && $shopping_cart->productsPrice > 70){
            $response_array['status'] = 'error'; 
            $response_array['message'] = "Vous bénéficiez déjà de la livraison gratuite."; 
            echo json_encode($response_array, JSON_PRETTY_PRINT);
            return;
        }

        //UPDATE SHOPPING CART WITH VOUCHER
        $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();
        $shopping_cart->voucher_id = $voucher->id;
        $shopping_cart->save();

        $shopping_cart->updateProductsPrice();
        $shopping_cart->updateShippingPrice();
        $shopping_cart->save();

        session(['shopping_cart' => $shopping_cart]);

        //RESPONSE OK
        $response_array['status'] = 'success'; 
        $response_array['message'] = "Le code a été ajouté au panier."; 
        echo json_encode($response_array, JSON_PRETTY_PRINT);
    }

    public function removeVoucher(Request $request){
        $shopping_cart = session('shopping_cart');
        foreach($shopping_cart->items as $item){
            $item->hasReduction = 0;
            $item->save();
        }
        $shopping_cart = ShoppingCart::where('id', $shopping_cart->id)->first();
        $shopping_cart->voucher_id = null;
        $shopping_cart->save();

        $shopping_cart->updateProductsPrice();
        $shopping_cart->updateShippingPrice();
        $shopping_cart->save();
        
        session(['shopping_cart' => $shopping_cart]);
    }
}
