<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('pages.auth.lost_password');
    }

    public function passwordReset(Request $request)
    {
        if (\App\User::where('email', $request->input('email'))->exists()){
            $passwordResetToken = rand(10000000, 99999999);

            $user = \App\User::where('email', $request->input('email'))->first();
            $user->passwordResetToken = $passwordResetToken;
            $user->save();

            Mail::to($user->email)->send(new \App\Mail\PasswordResetToken($passwordResetToken));

            $response = [
                'userId' => $user->id,
                'template' => view('components.modal.password_reset')->render()
            ];
        } else {
            $response = [
                'error' => [
                    'message' => 'Aucun compte n\'existe avec cet email.'
                ]
            ];
        }

        return JsonResponse::create($response, 200);
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:user']);
    }
}
