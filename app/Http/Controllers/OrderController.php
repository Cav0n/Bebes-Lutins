<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function search(Request $request)
    {
        $search_words = preg_split('/\s+/', $request['search']);

        $found_valid_orders = array();
        $found_possible_orders = array();
        $result = array();

        $orders = Order::where('id', '!=', null)->orderBy('created_at', 'asc')->get();
        $total_valid_words = count($search_words);

        foreach($orders as $order){
            $count_valid_words = 0;
            foreach($search_words as $word) {
                if (stripos(mb_strtoupper($order->user->firstname),mb_strtoupper($word)) !== false) $count_valid_words++;
                if (stripos(mb_strtoupper($order->user->lastname),mb_strtoupper($word)) !== false) $count_valid_words++;
                if (stripos(mb_strtoupper($order->user->mail),mb_strtoupper($word)) !== false) $count_valid_words++;
                if (stripos(mb_strtoupper($order->user->phone),mb_strtoupper($word)) !== false) $count_valid_words++;
                foreach($order->order_items as $item){
                    if (stripos(mb_strtoupper($item->product->name),mb_strtoupper($word)) !== false) {$count_valid_words++; break;}                    
                }

            }
            if($count_valid_words == $total_valid_words) {
                $found_valid_orders[$order->id] = $order;
                $found_valid_orders[$order->id]['color'] = \App\OrderStatus::statusToRGBColor($order->status);
            }
            else if($count_valid_words > 0){
                $found_possible_orders[$order->id] = $order;
                $found_possible_orders[$order->id]['color'] = \App\OrderStatus::statusToRGBColor($order->status);
            }
        }

        $result['valid_orders'] = $found_valid_orders;
        $result['possible_orders'] = $found_possible_orders;
        $result['valid_results_nb'] = count($found_valid_orders);

        header('Content-type: application/json');
        echo json_encode( $result, JSON_PRETTY_PRINT);
    }

    public function getJSON(Order $order)
    {
        $order_array = array();
        $order_array['id'] = $order->id;
        $order_array['status'] = $order->status;
        $order_array['shipping_price'] = $order->shippingPrice;
        $order_array['products_price'] = $order->productsPrice;
        $order_array['payment_method'] = $order->paymentMethod;
        
        $order_array['customer_message'] = $order->customerMessage;
        $order_array['shipping_address_id'] = $order->shipping_address_id;
        $order_array['billing_address_id'] = $order->billing_address_id;
        $order_array['is_canceled'] = $order->isCanceled;
        $order_array['created_at'] = $order->created_at;
        $order_array['updated_at'] = $order->updated_at;
        $order_array['user'] = $order->user;
        $order_array['voucher'] = $order->voucher;
        $order_array['items'] = $order->order_items;
        
        $data = [ 
            'order' => $order_array
        ];

        header('Content-type: application/json');
        echo json_encode( $data, JSON_PRETTY_PRINT);
    }

    public function addKnowThanksTo(Request $request)
    {
        if($request['answer'] != 'other') $request['answer_precision'] = null;

        DB::table('knowed_thanks_to')->insert([
            'answer' => $request['answer'],
            'answer_precision' => $request['answer_precision'],
            'user_id' => $request['user_id'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd(Order::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('A DESACTIVER - PAS BESOIN DE PAGE DE CREATION');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('pages.dashboard.orders.order')->withOrder($order);
    }

    public function showThanks()
    {
        return view('pages.shopping-cart.thanks');
    }

    public function showErrorPayment()
    {
        return view('pages.shopping-cart.payment-error');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        dd('A DESACTIVER - PAS BESOIN DE PAGE D\'ÉDITION');
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
        $order->status = $request['status'];
        $order->save();

        $result = \App\OrderStatus::statusToEmailMessage($order);

        Mail::to($order->user->email)->send(new \App\Mail\OrderUpdated($order, $result['title'], $result['message']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        dd($order);
    }
}
