<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreated;
use App\ShoppingCart;
use Auth;

class PageController extends Controller
{
    public function index()
    {
        return view('homepage');
    }

    public function test_mail()
    {
        $order = \App\Order::where('id', '5DB2BE7090')->first();

        Mail::to($order->user->email)->send(new \App\Mail\OrderCreated($order));
        echo 'OK';
    }

    public function test_mail_ui()
    {
        return view('emails.orders.order-created')->withOrder(\App\Order::where('id', '5DB2BE7090')->first());
    }
}
