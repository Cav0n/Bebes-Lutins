<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    public function index()
    {
        return view('index')->with([
            'homepageTitle' => \App\Setting::getValue('HOMEPAGE_TITLE'),
            'homepageDescription' => \App\Setting::getValue('HOMEPAGE_DESCRIPTION'),
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

        Mail::to($request->get('email'))->send(new Contact($request->get('firstname'), $request->get('lastname'), $request->get('email'), $request->get('message')));

        return redirect()->back()->with('success_message', 'Votre message a bien été envoyé.');
    }

    public function page404()
    {
        return abort(404);
    }
}
