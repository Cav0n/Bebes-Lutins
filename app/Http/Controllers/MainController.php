<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
}
