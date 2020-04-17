<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class SettingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SettingController
    |--------------------------------------------------------------------------
    |
    | This controller handle Setting model.
    |
    */

    public function __construct()
    {
        $this->middleware('admin')->only(['index', 'create', 'store', 'edit', 'update', 'saveAll']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.settings')->with('settings', \App\Setting::all());
    }

    public function saveAll(Request $request)
    {

        foreach (Setting::all() as $setting) {
            if (isset($request[$setting->key])) {
                $setting->value = $request[$setting->key];
            } else {
                $setting->value = 0;
            }

            $setting->save();
        }

        return back()->with('successMessage', 'Paramètres sauvegardés avec succés !');
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
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
