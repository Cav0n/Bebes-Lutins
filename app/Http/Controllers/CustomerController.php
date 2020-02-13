<?php

namespace App\Http\Controllers;

use App\User;

use Auth;
use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Search a user
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search_words = preg_split('/\s+/', $request['search']);

        $found_valid_customers = array();
        $found_possible_customers = array();
        $result = array();

        $customers = User::where('id', '!=', null)->orderBy('firstName', 'asc')->orderBy('lastName', 'asc')->get();
        $total_valid_words = count($search_words);

        foreach($customers as $customer){
            $count_valid_words = 0;
            $customer->phone = chunk_split($customer->phone, 2, " ");
            foreach($search_words as $word) {
                if (stripos(mb_strtoupper($customer->firstname),mb_strtoupper($word)) !== false) $count_valid_words++;
                else if (stripos(mb_strtoupper($customer->lastname),mb_strtoupper($word)) !== false) $count_valid_words++;
                else if (stripos(mb_strtoupper($customer->phone),mb_strtoupper($word)) !== false) $count_valid_words++;
            }
            if($count_valid_words == $total_valid_words) {$found_valid_customers[$customer->id] = $customer;}
            else if($count_valid_words > 0) $found_possible_customers[] = $customer;
        }
        
        $result['valid_customers'] = $found_valid_customers;
        $result['possible_customers'] = $found_possible_customers;
        $result['valid_results_nb'] = count($found_valid_customers);

        header('Content-type: application/json');
        echo json_encode( $result, JSON_PRETTY_PRINT);
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'firstname' => 'min:2|required',
            'lastname' => 'min:2|required',
            'phone' => 'size:10|nullable',
        ]);

        $user = Auth::user();

        $user->firstname = $request['firstname'];
        $user->lastname = $request['lastname'];
        $user->phone = $request['phone'];
        $user->birthdate = $request['birthdate'];
        $user->save();

        $result['code'] = 200;
        $result['message'] = 'Profil mis à jour avec succés.';
        
        return response()->json($result);
    }

    public function updatePasswordOnly(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'new_password' => 'required|min:8',
        ]);
        
        // CHECK OLD PASSWORD
        if (Hash::check($request['old_password'], $user->password)) {
            $user->password = Hash::make($request['new_password']);
            $user->save();

            $result['success'] = 'Mot de passe modifié avec succés.';
            $code = 200;
        } else {
            $result['errors'] = ['old_password' => 'Mot de passe incorrect'];
            $result['message'] = 'Ancien mot de passe incorrect.';
            $code = 300;
        }

        return response()->json($result, $code);
    }

    public function resetPasswordCode(Request $request)
    {
        $email = $request['email'];

        if(User::where('email', $email)->exists()){
            $user = User::where('email', $email)->first();
            $user->resetCode = rand(10000000,99999999);
            $user->save();

            Mail::to($email)->send(new ResetPassword($user));
            $result['message'] = 'Le compte existe';
            $code = 200;
        } else {
            $result['message'] = 'Le compte n\'existe pas';
            $code = 300;
        }

        return response()->json($result, $code);
    }

    public function verifyResetCode(Request $request)
    {
        $email = $request['email'];

        if(User::where('email', $email)->where('resetCode', $request['confirmation_code'])->exists()){
            $result['message'] = 'Le code est bon';
            $code = 200;
        } else {
            $result['message'] = 'Le code est incorrect';
            $code = 300;
        }

        return response()->json($result, $code);
    }

    public function resetPassword(Request $request){
        $email = $request['email'];
        $confirmationCode = $request['confirmation_code'];
        $newPassword = $request['new_password'];

        if(User::where('email', $email)->where('resetCode', $request['confirmation_code'])->exists()){
            $user = User::where('email', $email)->first();
            $user->password = Hash::make($newPassword);
            $user->save();

            Mail::to($email)->send(new \App\Mail\PasswordReseted($user));
            $result['new_password'] = $newPassword;
            $result['message'] = 'Mot de passe modifié';
            $code = 200;
        } else {
            $result['message'] = 'Un problème est survenu';
            $code = 300;
        }

        return response()->json($result, $code);
    }
}
