<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function verifyResetCode(Request $request)
    {
        $user = \App\User::where('id', $request['user'])->first();
        $code = $request['code'];

        if ($code === $user->passwordResetToken) {
            $response = [
                'inputTemplate' => view('components.utils.auth.password.new_password_input')->render(),
                'btnTemplate' => view('components.utils.auth.password.new_password_btn')->render()
            ];
        } else {
            $response = ['error' => ['message' => 'Le code ne correspond pas.']];
        }

        return JsonResponse::create($response, 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
        ]);

        $user = \App\User::where('id', $request['user'])->first();
        $user->password = Hash::make($request['password']);
        $user->save();

        $response = ['message' => 'ok'];

        return JsonResponse::create($response, 200);
    }
}
