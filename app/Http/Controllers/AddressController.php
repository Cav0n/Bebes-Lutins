<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use Auth;

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
        return view('pages.customer-area.addresses.creation');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'civility' => 'numeric|max:3|required',
            'firstname' => 'alpha|required',
            'lastname' => 'alpha|required',
            'street' => 'required',
            'zipcode' => 'numeric|max:95880|required',
            'city' => 'required',
        ]);

        $address = new Address();
        $address->id = substr(uniqid(), 0, 10);
        $address->civility = $validated_data['civility'];
        $address->firstname = $validated_data['firstname'];
        $address->lastname = $validated_data['lastname'];
        $address->street = $validated_data['street'];
        $address->zipCode = $validated_data['zipcode'];
        $address->city = $validated_data['city'];
        $address->complement = $request['complement'];
        $address->company = $request['company'];

        if(Auth::check()) $address->user_id = Auth::user()->id;

        $address->save();

        $request->session()->flash('success', 'Votre adresse à bien été ajoutée.');

        return redirect('/espace-client/adresses');
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
        return view('pages.customer-area.addresses.edition')->withAddress($address);
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
        $validated_data = $request->validate([
            'civility' => 'numeric|max:3|required',
            'firstname' => 'alpha|required',
            'lastname' => 'alpha|required',
            'street' => 'required',
            'zipcode' => 'numeric|max:95880|required',
            'city' => 'required',
        ]);

        $address->civility = $validated_data['civility'];
        $address->firstname = $validated_data['firstname'];
        $address->lastname = $validated_data['lastname'];
        $address->street = $validated_data['street'];
        $address->zipCode = $validated_data['zipcode'];
        $address->city = $validated_data['city'];
        $address->complement = $request['complement'];
        $address->company = $request['company'];

        $address->save();

        $request->session()->flash('success', 'Votre adresse à bien été mis à jour.');

        return redirect('/espace-client/adresses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        $address->is_deleted = true;
        $address->save();
    }
}
