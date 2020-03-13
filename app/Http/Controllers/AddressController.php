<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
    public function store(Request $request, $nestedKey = null)
    {
        $address = new Address();

        $this->validator($request->all())->validate();

        if (null != $nestedKey) {
            $nestedKey .= '.';
        }

        $address->civility = $request->input($nestedKey . 'civility');
        $address->firstname = $request->input($nestedKey . 'firstname');
        $address->lastname = $request->input($nestedKey . 'lastname');
        $address->street = $request->input($nestedKey . 'street');
        $address->zipCode = $request->input($nestedKey . 'zipCode');
        $address->city = $request->input($nestedKey . 'city');
        $address->complements = $request->input($nestedKey . 'complements');
        $address->company = $request->input($nestedKey . 'company');
        $address->user_id = $request->input($nestedKey . 'user_id');

        $address->save();

        if ($request->input('back')) {
            return back();
        }

        return $address->id;
    }

    public function storeArray(array $input)
    {
        $this->validator($input)->validate();

        $address = new Address();
        $address->civility = $input['civility'];
        $address->firstname = $input['firstname'];
        $address->lastname = $input['lastname'];
        $address->street = $input['street'];
        $address->zipCode = $input['zipCode'];
        $address->city = $input['city'];
        $address->complements = $input['complements'];
        $address->company = $input['company'];
        $address->user_id = $input['user_id'];

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

    protected function validator(array $data)
    {
        $rules = [];

        if (isset($data['is-new-billing-address'])) {
            $rules += [
                'billing.civility' => ['required', 'string', Rule::in(['Madame', 'Monsieur', 'Non précisé'])],
                'billing.firstname' => ['required', 'string', 'min:2', 'max:255'],
                'billing.lastname' => ['required', 'string', 'min:2', 'max:255'],
                'billing.street' => ['required', 'string'],
                'billing.zipCode' => ['required', 'string', 'size:5'],
                'billing.city' => ['required', 'string'],
                'billing.complements' => ['string', 'nullable'],
                'billing.company' => ['string', 'nullable'],
            ];
        }

        if (isset($data['is-new-shipping-address']) && (!isset($data['sameAddresses']))) {
            $rules += [
                'shipping.civility' => ['required', 'string', Rule::in(['Madame', 'Monsieur', 'Non précisé'])],
                'shipping.firstname' => ['required', 'string', 'min:2', 'max:255'],
                'shipping.lastname' => ['required', 'string', 'min:2', 'max:255'],
                'shipping.street' => ['required', 'string'],
                'shipping.zipCode' => ['required', 'string', 'size:5'],
                'shipping.city' => ['required', 'string'],
                'shipping.complements' => ['string', 'nullable'],
                'shipping.company' => ['string', 'nullable'],
            ];
        }

        if (empty($rules)) {
            $rules += [
                'civility' => ['required', 'string', Rule::in(['Madame', 'Monsieur', 'Non précisé'])],
                'firstname' => ['required', 'string', 'min:2', 'max:255'],
                'lastname' => ['required', 'string', 'min:2', 'max:255'],
                'street' => ['required', 'string'],
                'zipCode' => ['required', 'string', 'size:5'],
                'city' => ['required', 'string'],
                'complements' => ['string', 'nullable'],
                'company' => ['string', 'nullable'],
            ];
        }

        return Validator::make($data, $rules);
    }
}
