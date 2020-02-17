<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function thanks()
    {
        return view('pages.shopping_cart.thanks');
    }
}
