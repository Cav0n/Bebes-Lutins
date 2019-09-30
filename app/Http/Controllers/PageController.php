<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        ShoppingCartController::createNew();
        return view('homepage');
    }
}
