<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * A custom login controller for admin backoffice.
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | [ADMIN] - Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('notAdmin', ['except' => 'logout']);
    }

    /**
     * Show admin login page
     */
    public function showLoginPage()
    {
        return view('pages.admin.auth.login');
    }

    /**
     * Admin custom login
     */
    public function login(Request $request)
    {
        // Define error message and rules
        $loginErrorMessage = ['exists' => 'L\'email ou le mot de passe est incorrect.'];
        $passwordRule = ['password' => 'required'];
        $emailRule = ['email' => 'required|email:filter|exists:admins'];

        // Double validation to let user know if password or email is false when there is no
        // password but email exists.
        $passwordValidator = Validator::make($request->input(), $passwordRule, $loginErrorMessage)->validate();
        $emailValidator = Validator::make($request->input(), $emailRule, $loginErrorMessage)->validate();

        // If there is a bug while getting admin model return error.
        if(null === $admin = \App\Admin::where('email', $request['email'])->first()) {
            return back()->withInput(['email' => $request['email']])
                         ->withErrors(['email' => 'L\'email ou le mot de passe est incorrect.', ]);
        }

        // Check password and connect admin
        if (Hash::check($request['password'], $admin->password)) {
            session()->put('admin', $admin);
        }

        return back()->withInput(['email' => $request['email']])
                     ->withErrors(['email' => 'L\'email ou le mot de passe est incorrect.', ]);
    }

    /**
     * Admin custom logout
     */
    public function logout()
    {
        session()->forget('shopping_cart');
        session()->regenerate();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }
}
