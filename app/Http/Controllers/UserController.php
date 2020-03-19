<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class UserController extends Controller
{
    public function importFromJSON()
    {
        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/customers');
        $result = json_decode($res->getBody());

        foreach($result as $r) {
            if (User::where('email', $r->email)->exists()) {
                continue;
            }
            $user = new User();
            $user->firstname = $r->firstname;
            $user->lastname = $r->lastname;
            $user->phone = $r->phone;
            $user->email = $r->email;
            $user->password = $r->password;
            $user->wantNewsletter = $r->wantNewsletter;
            $user->created_at = $r->created_at;
            $user->updated_at = $r->updated_at;
            $user->save();
        }

        echo 'Users imported !' . "\n";
    }

    public function toggleNewsletters(Request $request, User $user){
        $user->wantNewsletter = !$user->wantNewsletter;
        $user->save();

        return back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = User::orderBy('created_at', 'desc')->paginate(15);

        return view('pages.admin.customers', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $product
     * @return \Illuminate\Http\Response
     */
    public function show(User $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(User $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $product)
    {
        //
    }
}
