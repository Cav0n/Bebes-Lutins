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
    public function exportPage(Request $request)
    {
        return view('pages.dashboard.orders.export')->withOrders(Order::all());
    }

    public function generateCustomExport(Request $request)
    {
        $orders = Order::where('id', '!=', null);

        //FIRST DATE
        if($request['first_date'] != null){
            $first_date = $request['first_date'];
            $orders = $orders->where('created_at', '>=', $first_date);
        } else $first_date = null;

        //LAST DATE
        if($request['last_date'] != null){
            $last_date = $request['last_date'];
            $orders = $orders->where('created_at', '<=', $last_date);
        } else $last_date = null;

        //STATUS
        if($request['status'] != null){
            $status = $request['status'];
            $orders = $orders->whereIn('status', $status);
        } else $status = null;

        //MINIMUM PRICE
        if($request['minimum_price'] != null){
            $minimum_price = $request['minimum_price'];
            $orders = $orders->where('productsPrice', '>=', $minimum_price);
        } else $minimum_price = 0;

        //MAXIMUM PRICE
        if($request['maximum_price'] != null){
            $maximum_price = $request['maximum_price'];
            $orders = $orders->where('productsPrice', '<=', $maximum_price);
        } else $maximum_price = 0;

        //WANT SHIPPING PRICE
        $want_shipping_price =  $request['want_shipping_price'];
        if(! $want_shipping_price) $orders = $orders->where('shippingPrice', 0);

        return view('pages.dashboard.orders.export')->withOrders($orders->orderBy('created_at', 'desc')->get())->withRequest($request);
    }

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
        $user = $order->user; // THIS PERMIT TO INIT USER IN RESPONSE
        return response()->json(['order' => $order], 200);
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

        if($request['notify_customer'] == 'true'){
            Mail::to($order->user->email)->send(new \App\Mail\OrderUpdated($order, $result['title'], $result['message']));
            $response['message'] = $request['notify_customer'];
            $response['code'] = 200;
        }

        // return response()->json($response, $response['code']);
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
