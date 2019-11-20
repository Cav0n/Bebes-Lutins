<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Address;
use App\Mail\AccountCreated;
use App\Http\Requests\Login; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


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
        $this->middleware('guest')->only('loginPage', 'registerPage');
    }

    public function index(){
        if (Auth::check()) {
            return redirect('/espace-client/profil');
        } else return redirect('/espace-client/connexion');
    }

    public function loginPage(){
        return view('pages.customer-area.login');
    }

    public function login(Login $request){
        $request->validate([
            'email' => 'email|exists:users|required',
            'password' => 'required'
        ]);
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'] ];

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();
            Auth::login($user);
            $redirectTo = $request->session()->get('returnTo', '/espace-client/profil');
            $request->session()->forget('returnTo');
            return redirect($redirectTo);
        } else {
            return redirect('/espace-client/connexion')->withErrors(['password' => 'Mot de passe incorrect'])->withInput(['email'=>$request['email']]);
        }
    }

    public function registerPage(){
        return view('pages.customer-area.register');
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

        Mail::to("super_craftman@hotmail.fr")->send(new AccountCreated($user));

        return redirect('/espace-client');
    }

    public function resetPasswordPage(Request $request){
        return view('pages.customer-area.reset-password');
    }

    public function profilPage(){
        return view('pages.customer-area.profil');
    }

    public function ordersPage(){
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('pages.customer-area.orders')->withOrders($orders);
    }

    public function addressPage(){
        $addresses = Auth::user()->addresses;
        return view('pages.customer-area.address')->withAddresses($addresses);
    }

    public function invertNewsletter(){
        Auth::user()->wantNewsletter = !Auth::user()->wantNewsletter;
        Auth::user()->save();
    }
}
