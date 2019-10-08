<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use Auth;

class AddressController extends Controller
{
    public function get(Address $address)
    {
        $address_array = array();
        $address_array['civility'] = $address->civilityToString();
        $address_array['firstname'] = $address->firstname;
        $address_array['lastname'] = $address->lastname;
        $address_array['street'] = $address->street;
        $address_array['zipcode'] = $address->zipCode;
        $address_array['city'] = $address->city;
        $address_array['complement'] = $address->complement;
        $address_array['company'] = $address->company;
        $data = [ 'address' => $address_array ];

        header('Content-type: application/json');
        echo json_encode( $data );
    }

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
    public static function store(Request $request)
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
        $address->firstname = ucfirst($validated_data['firstname']);
        $address->lastname = mb_strtoupper($validated_data['lastname']);
        $address->street = $validated_data['street'];
        $address->zipCode = $validated_data['zipcode'];
        $address->city = mb_strtoupper($validated_data['city']);
        $address->complement = $request['complement'];
        $address->company = $request['company'];

        if(Auth::check()) $address->user_id = Auth::user()->id;

        /* FOR WITHDRAWAL SHOP */
        if($request['email'] != null) $address->email = $request['email'];
        if($request['phone'] != null) $address->phone = $request['phone'];
        /* ------ */

        $address->save();

        /* If not actually in shopping cart */
        if($request['delivery-type'] == null){
            $request->session()->flash('success', 'Votre adresse à bien été ajoutée.');
            return redirect('/espace-client/adresses');
        } else { return $address->id; } 
        /* ------ */
    }

    public static function storeBilling(Request $request)
    {
        $validated_data = $request->validate([
            'civility-billing' => 'numeric|max:3|required',
            'firstname-billing' => 'alpha|required',
            'lastname-billing' => 'alpha|required',
            'street-billing' => 'required',
            'zipcode-billing' => 'numeric|max:95880|required',
            'city-billing' => 'required',
        ]);

        $address = new Address();
        $address->id = substr(uniqid(), 0, 10);
        $address->civility = $validated_data['civility-billing'];
        $address->firstname = ucfirst($validated_data['firstname-billing']);
        $address->lastname = mb_strtoupper($validated_data['lastname-billing']);
        $address->street = $validated_data['street-billing'];
        $address->zipCode = $validated_data['zipcode-billing'];
        $address->city = mb_strtoupper($validated_data['city-billing']);
        $address->complement = $request['complement-billing'];
        $address->company = $request['company-billing'];

        if(Auth::check()) $address->user_id = Auth::user()->id;
        
        $address->save();

        return $address->id;
    }

    public static function storeShipping(Request $request)
    {
        $validated_data = $request->validate([
            'civility-shipping' => 'numeric|max:3|required',
            'firstname-shipping' => 'alpha|required',
            'lastname-shipping' => 'alpha|required',
            'street-shipping' => 'required',
            'zipcode-shipping' => 'numeric|max:95880|required',
            'city-shipping' => 'required',
        ]);

        $address = new Address();
        $address->id = substr(uniqid(), 0, 10);
        $address->civility = $validated_data['civility-shipping'];
        $address->firstname = ucfirst($validated_data['firstname-shipping']);
        $address->lastname = mb_strtoupper($validated_data['lastname-shipping']);
        $address->street = $validated_data['street-shipping'];
        $address->zipCode = $validated_data['zipcode-shipping'];
        $address->city = mb_strtoupper($validated_data['city-shipping']);
        $address->complement = $request['complement-shipping'];
        $address->company = $request['company-shipping'];

        if(Auth::check()) $address->user_id = Auth::user()->id;

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
