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
        Mail::to("super_craftman@hotmail.fr")->send(new AccountCreated());
        echo 'OK';
    }

    public function test_mail_ui()
    {
        return view('emails.account.account-created');
    }
}
