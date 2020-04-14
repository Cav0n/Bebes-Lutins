<?php

namespace App\Http\Controllers;

use App\Order;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['index', 'create', 'edit']);
    }

    public function importFromJSON()
    {
        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/orders');
        $result = json_decode($res->getBody());

        Order::destroy(Order::all());

        $count = 0;
        foreach ($result as $r) {
            $order = new Order();
            $order->status = $this->integerStatusToStringStatus($r->status);
            $order->paymentMethod = $this->integerPaymentMethodToStringPaymentMethod($r->paymentMethod);
            $order->shippingCosts = $r->shippingPrice;
            $order->email = $r->user->email;
            $order->phone = $r->user->phone;
            $order->trackingNumber = $r->id;
            $order->comment = $r->customerMessage;
            $order->billing_address_id = \App\Address::where('street', $r->billing_address->street)->where('lastname', $r->billing_address->lastname)->first()->id;
            $order->shipping_address_id = $r->shipping_address ? \App\Address::where('street', $r->shipping_address->street)->where('lastname', $r->shipping_address->lastname)->first()->id : null;
            $order->user_id = $r->user ? \App\User::where('email', $r->user->email)->exists() ? \App\User::where('email', $r->user->email)->first()->id  : null : null;
            $order->created_at = $r->created_at;
            $order->updated_at = $r->updated_at;
            $order->save();
            $count++;
        }
        echo $count . ' orders imported !' . "\n";
    }

    public function integerStatusToStringStatus(int $status)
    {
        switch ($status) {
            case 0:
                return 'WAITING_PAYMENT';
            break;
            case 1:
                return 'PROCESSING';
            break;
            case 2:
                return 'DELIVERING';
            break;
            case 22:
                return 'WITHDRAWAL';
            break;
            case 3:
                return 'DELIVERED';
            break;
            case 33:
                return 'REGISTERED_PARTICIPATION';
            break;
            case -1:
                return 'CANCELED';
            break;
            case -2:
                return 'REFUSED_PAYMENT';
            break;
            case -3:
                return 'REFUSED_PAYMENT';
            break;
            default:
                return 'STATUS_ERROR';
            break;
        }
    }

    public function integerPaymentMethodToStringPaymentMethod(int $paymentMethod)
    {
        switch ($paymentMethod) {
            case 1:
                return 'CARD';
            break;
            case 2:
                return 'CHEQUE';
            break;
            default:
                return 'PAYMENT_METHOD_ERROR';
            break;
        }
    }

    public function showTrackingPage()
    {
        return view('pages.order.tracking');
    }

    public function tracking(Request $request, string $trackingNumber)
    {
        if (null !== $order = Order::where('trackingNumber', $trackingNumber)->first()){
            return JsonResponse::create(['order' => View::make('components.utils.orders.order', ['order' => $order, 'bgColor' => 'bg-white'])
                                                    ->render()]);
        }

        return JsonResponse::create(['error' => ['message' => trans('messages.There is no order with this tracking number.')] ]);
    }

    public function showBill(Request $request, Order $order)
    {
        if (\App\Admin::check() || (Auth::check() && $order->user_id == Auth::user()->id)){
            return view('pages.order.bill')->with(['order' => $order]);
        }
        return abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Commandes';

        if (null !== $request['status']) {
            $orders = \App\Order::whereIn('status', $request['status'])->orderBy('created_at', 'desc');
            foreach ($request['status'] as $status) {
                $title .= ' <span class="badge badge-pill badge-dark small" style="font-size:12px;">' . trans('order.status.' . $status) . '</span>';
            }
        } else {
            $orders = \App\Order::orderBy('created_at', 'desc');
        }

        return view('pages.admin.orders')->withOrders($orders->paginate(15))->withCardTitle($title);
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
        $order = new Order();
        $order->status = 'WAIT_PAYMENT';
        $order->shippingCosts = $request['shippingCosts'];
        $order->email = $request['email'];
        $order->phone = $request['phone'];
        $order->billing_address_id = $request['billing_address_id'];
        $order->shipping_address_id = $request['shipping_address_id'];
        $order->user_id = $request['user_id'];
        $order->voucher_id = $request['voucher_id'];

        $order->save();
    }

    public function createFromCart(Request $request, \App\Cart $cart)
    {
        $order = new Order();
        $order->status = 'WAITING_PAYMENT';
        $order->shippingCosts = $cart->shippingCosts;
        $order->paymentMethod = $request['paymentMethod'];
        $order->email = $cart->email;
        $order->phone = $cart->phone;

        $order->billing_address_id = $cart->billingAddress->id;
        if ($cart->shippingAddress) $order->shipping_address_id = $cart->shippingAddress->id;
        if ($cart->user) $order->user_id = $cart->user->id;
        $order->voucher_id = $cart->voucher_id;
        $order->comment = $cart->comment;

        $order->trackingNumber = uniqid();

        $order->save();

        foreach($cart->items as $item){
            $orderItem = new \App\OrderItem();
            $orderItem->quantity = $item->quantity;
            $orderItem->unitPrice = $item->product->price;
            $orderItem->product_id = $item->product->id;
            $orderItem->order_id = $order->id;

            $orderItem->save();

            $orderItem->product->stock -= $item->quantity;
            $orderItem->product->save();
        }

        $cart = session()->get('shopping_cart');
        $cart->isActive = 0;
        $cart->save();

        session()->forget('shopping_cart');
        session()->regenerate();

        return redirect(route('thanks', ['order' => $order]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('pages.admin.order')->withOrder($order);
    }


    public function showThanks(Request $request, \App\Order $order)
    {
        $step = 4;

        return view('pages.shopping_cart.thanks')->withOrder($order)->withCartStep($step);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        if (null !== $status = $request['status']) {
            $order->status = $status;
        }

        $order->save();

        return new JsonResponse(['message' => 'ok', 'color' => $order->statusColor], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
