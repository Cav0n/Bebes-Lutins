<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, \App\User $user = null)
    {
        $address = new Address();
        $address->civility = $request->input('civility');
        $address->firstname = $request->input('firstname');
        $address->lastname = $request->input('lastname');
        $address->street = $request->input('street');
        $address->zipCode = $request->input('zipCode');
        $address->city = $request->input('city');
        $address->complements = $request->input('complements');
        $address->company = $request->input('company');
        if($user) $address->user_id = $user->id;

        $address->save();
    }

    public function storeArray(array $input, \App\User $user = null)
    {
        $address = new Address();
        $address->civility = $input['civility'];
        $address->firstname = $input['firstname'];
        $address->lastname = $input['lastname'];
        $address->street = $input['street'];
        $address->zipCode = $input['zipCode'];
        $address->city = $input['city'];
        $address->complements = $input['complements'];
        $address->company = $input['company'];
        if($user) $address->user_id = $user->id;

        $address->save();

        return $address->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
    }
}
