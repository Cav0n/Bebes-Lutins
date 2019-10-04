<?php

namespace App\Http\Controllers;

use \App\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(){
        return redirect('/dashboard/commandes/en-cours');
    }

    public function orders(string $status = null){
        if(session()->has('selected_order_status' . $status)){
            $orders = Order::where('status', '=', session('selected_order_status'.$status))->orderBy('created_at', 'desc')->paginate(15); 
        }

        switch($status){
            case 'en-cours':
                if(!isset($orders)){
                    $orders = Order::where('status', '>=', 0)->where('status', '!=', 3)->where('status', '!=', '33')->orderBy('created_at', 'desc')->paginate(15); 
                }
                $old_status = $status;
                $status = "en cours";
                break;

            case 'terminees':
                if(!isset($orders)){
                    $orders = Order::where('status', '!=', 22)->where('status', '>=', 3)->orderBy('created_at', 'desc')->paginate(15);
                }
                $old_status = $status;
                $status = "terminées";
                break;

            case 'refusees':
                if(!isset($orders)){
                    $orders = Order::where('status', '=', -3)->paginate(15);
                }
                $old_status = $status;
                $status = "refusées";
                break;

            default:
                return redirect('/dashboard/commandes/en-cours');
                break;
        }
        return view('pages.dashboard.orders')->withStatus($status)->withOrders($orders)->withOldStatus($old_status);
    }

    public function products(){
        return view('pages.dashboard.products');
    }

    public function stocks(){
        return view('pages.dashboard.stocks');
    }

    public function categories(){
        return view('pages.dashboard.categories');
    }

    public function customers(){
        return view('pages.dashboard.customers');
    }

    public function reviews(){
        return view('pages.dashboard.reviews');
    }

    public function vouchers(){

    }

    public function newsletters(){

    }

    public function select_order_status(Request $request){
        $selected_order_status = array();
        $selected_order_status = $request['status'];
        $page = $request['page'];
        session(['selected_order_status' . $page => $selected_order_status]);
    }

    public function unselect_order_status(Request $request){
        $request->session()->forget('selected_order_status' . $request['page']);
    }
}
