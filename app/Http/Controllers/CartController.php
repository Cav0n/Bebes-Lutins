<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class CartController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CartController
    |--------------------------------------------------------------------------
    |
    | This controller handle Cart model.
    |
    */

    /** @var string */
    protected $alertMessage;

    public function __construct()
    {
        $this->alertMessage = \App\Setting::getValue('ALERT_MESSAGE_ACTIVATED') ? \App\Setting::getValue('ALERT_MESSAGE') : null;
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
    public function create(\App\User $user = null, string $sessionId = null)
    {
        $cart = new Cart();
        $cart->isActive = true;
        $cart->sessionId = $sessionId;
        if ($user) $cart->user_id = $user->id;
        $cart->save();

        session()->put('shopping_cart', $cart);
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
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart = null)
    {
        $cart = Cart::where('id', Session::get('shopping_cart')->id)->first();
        [$cart, $notAvailableItems, $stockDecreasedItems] = self::verifyItemsAvailability($cart);
        $step = 1;

        if ($cart->items->isEmpty()) {
            $step = 0;
        }

        return view('pages.shopping_cart.index')
                ->withCartStep($step)
                ->withCart($cart)
                ->withUnavailableItems($notAvailableItems)
                ->withstockDecreasedItems($stockDecreasedItems)
                ->withAlertMessage($this->alertMessage);
    }

    public function verifyItemsAvailability(Cart $cart)
    {
        $notAvailableItems = [];
        $stockDecreasedItems = [];

        foreach ($cart->items as $item) {
            // If product Unavailable
            if (0 >= $item->product->stock) {
                $notAvailableItems[] = $item;
                $cart->items()->where('id', $item->id)->delete();
            }

            // If product stock descreased
            if ($item->product->stock < $item->quantity) {
                $stockDecreasedItems[] = $item;
                $item->quantity = $item->quantity - ($item->quantity - $item->product->stock);
                $item->save();
            }
        }

        // Update database and local cart
        if (!empty($notAvailableItems) && !empty($stockDecreasedItems)) {
            $cart->save();
            $cart = Cart::where('id', $cart->id)->first();
        }

        return [$cart, $notAvailableItems, $stockDecreasedItems];
    }

    public function showDelivery()
    {
        $cart = Cart::where('id', Session::get('shopping_cart')->id)->first();
        [$cart, $notAvailableItems, $stockDecreasedItems] = self::verifyItemsAvailability($cart);
        $step = 2;

        return view('pages.shopping_cart.delivery')
                ->withCartStep($step)
                ->withCart($cart)
                ->withUnavailableItems($notAvailableItems)
                ->withstockDecreasedItems($stockDecreasedItems)
                ->withAlertMessage($this->alertMessage);
    }

    public function addAddresses(Request $request)
    {
        $addressController = new AddressController();

        $request->validate([
            'email' => ['required', 'email:filter'],
        ]);

        // Billing address creation
        if ($request->input('is-new-billing-address')){
            $billingAddressId = $addressController->store($request, 'billing');
        } else {
            $billingAddressId = $request->input('billing-address-id');
        }

        // Shipping address creation
        if (null !== $request->input('sameAddresses') && $request->input('sameAddresses')) {
            $shippingAddressId = $billingAddressId;
        } else {
            if ($request->input('is-new-shipping-address')){
                $shippingAddressId = $addressController->store($request, 'shipping');
            } else {
                $shippingAddressId = $request->input('shipping-address-id');
            }
        }

        $cart = session()->get('shopping_cart');

        $cart->email = $request->input('email');
        $cart->phone = $request->input('phone');

        $cart->billing_address_id = $billingAddressId;
        $cart->shipping_address_id = $shippingAddressId;
        $cart->save();

        session()->put('shopping_cart', $cart);

        return redirect(route('cart.payment'));
    }

    public function showPayment()
    {
        $cart = Cart::where('id', Session::get('shopping_cart')->id)->first();
        [$cart, $notAvailableItems, $stockDecreasedItems] = self::verifyItemsAvailability($cart);
        $step = 3;

        return view('pages.shopping_cart.payment')
                ->withCartStep($step)
                ->withCart($cart)
                ->withUnavailableItems($notAvailableItems)
                ->withstockDecreasedItems($stockDecreasedItems)
                ->withAlertMessage($this->alertMessage);
    }

    public function addComment(Request $request)
    {
        $cart = Cart::where('id', $request['cartId'])->first();
        $cart->comment = $request['comment'];
        $cart->save();

        return JsonResponse::create(['message' => 'Commentaire ajouté avec succés'], 200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
