<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreated;
use App\ShoppingCart;
use Auth;

class StaticPageController extends Controller
{
    public function __construct()
    {
        
    }

    public function guide_and_tips()
    {
        return view("pages.statics.en-savoir-plus.guide-and-tips");
    }

    public function who()
    {
        return view("pages.statics.en-savoir-plus.who");
    }

    public function why()
    {
        return view("pages.statics.en-savoir-plus.why");
    }

    public function maintenance()
    {
        return view("pages.statics.en-savoir-plus.maintenance");
    }

    public function manual()
    {
        return view("pages.statics.en-savoir-plus.manual");
    }

    public function how()
    {
        return view("pages.statics.en-savoir-plus.how");
    }

    public function resellers()
    {
        return view("pages.statics.en-savoir-plus.resellers");
    }

    public function shipping()
    {
        return view("pages.statics.infos-pratiques.shipping");
    }

    public function payment()
    {
        return view("pages.statics.infos-pratiques.payment");
    }

    public function return()
    {
        return view("pages.statics.infos-pratiques.return");
    }

    public function legal_notice()
    {
        return view("pages.statics.infos-pratiques.legal-notice");
    }

    public function terms_of_sales()
    {
        return view("pages.statics.infos-pratiques.terms-of-sales");
    }
}
