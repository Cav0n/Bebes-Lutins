<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class MainController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MainController
    |--------------------------------------------------------------------------
    |
    | This controller handle main navigation.
    |
    */

    public function index()
    {
        return view('index')->with([
            'homepageTitle' => \App\Setting::getValue('HOMEPAGE_TITLE'),
            'homepageDescription' => \App\Setting::getValue('HOMEPAGE_DESCRIPTION'),
            'products' => \App\Product::where('isDeleted', 0)->where('isHidden', 0),
            'carouselItems' => \App\CarouselItem::all(),
            'alertMessage' => \App\Setting::getValue('ALERT_MESSAGE_ACTIVATED') ? \App\Setting::getValue('ALERT_MESSAGE') : null
        ]);
    }

    public function showContact(Request $request)
    {
        return view('pages.static.contact');
    }

    public function contact(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'email:filter|required',
            'message' => 'required|min:10',

        ]);

        try {
            Mail::to($request->get('email'))->send(new Contact($request->get('firstname'), $request->get('lastname'), $request->get('email'), $request->get('message')));
        } catch (Exception $e) {
            Log::error('MAIL ERROR : ' . $e->getMessage());
        }


        return redirect()->back()->with('success_message', 'Votre message a bien été envoyé.');
    }

    public function page404()
    {
        return abort(404);
    }

    public function testMail()
    {
        return new \App\Mail\Test();
    }
}
