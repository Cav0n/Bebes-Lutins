<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Address;
use App\Http\Requests\Login; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAreaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only('index', 'profilPage', 'ordersPage', 'addressPage');
    }

    public function index(){
        if (Auth::check()) {
            return redirect('/espace-client/profil');
        } else return redirect('/espace-client/connexion');
    }

    public function loginPage(){
        if (Auth::check()) {
            return redirect('/espace-client/profil');
        } else return view('pages.customer-area.login');
    }

    public function login(Login $request){
        if (Auth::check()) {
            return redirect('/espace-client/profil');
        } else return redirect('/login');
    }

    public function registerPage(){
        if (Auth::check()) {
            return redirect('/espace-client/profil');
        } else return view('pages.customer-area.register');
    }

    public function register(Request $request){
        $validated_data = $request->validate([
            'firstname' => 'min:3|required',
            'lastname' => 'min:3|required',
            'email' => 'email:filter|unique:users|required',
            'password' => 'min:6|confirmed|required',
        ]);

        $user = new User();
        $user->id = uniqid();
        $user->email = $validated_data['email'];
        $user->phone = null;
        $user->password = Hash::make($validated_data['password']);
        $user->firstname = ucfirst($validated_data['firstname']);
        $user->lastname = mb_strtoupper($validated_data['lastname']);
        if($request['want-newsletter'] != null) $user->wantNewsletter = true;
        
        $user->save();

        Auth::login($user);

        return redirect('/espace-client');
    }

    public function profilPage(){
        return view('pages.customer-area.profil');
    }

    public function ordersPage(){
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('pages.customer-area.orders')->withOrders($orders);
    }

    public function addressPage(){
        $addresses = Auth::user()->addresses->where('is_deleted', 0);
        return view('pages.customer-area.address')->withAddresses($addresses);
    }

    public function invertNewsletter(){
        Auth::user()->wantNewsletter = !Auth::user()->wantNewsletter;
        Auth::user()->save();
    }
}
