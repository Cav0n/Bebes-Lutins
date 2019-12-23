<?php

namespace App\Http\Controllers;

use App\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.parameters');
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
     * @param  \App\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function show(Parameter $parameter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function edit(Parameter $parameter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $informationMessage = $request['informationMessage'];
        $informationMessageBackgroundColor = $request['backgroundcolor'];
        $informationMessageTextColor = $request['textcolor'];

        $informationMessageParam = Parameter::where('name', 'informationMessage')->first();
        $informationMessageParam->value = $informationMessage;
        $informationMessageParam->save();

        $informationMessageBgColor = Parameter::where('name', 'informationMessageBackgroundColor')->first();
        $informationMessageBgColor->value = $informationMessageBackgroundColor;
        $informationMessageBgColor->save();

        $informationMessageTextColor = Parameter::where('name', 'informationMessageTextColor')->first();
        $informationMessageTextColor->value = $informationMessageTextColor;
        $informationMessageTextColor->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parameter $parameter)
    {
        //
    }
}
