<?php

namespace App\Http\Controllers;

use App\Setting;
use App\SettingsI18n;
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

    /**
     * Generate all settings from JSON in /config/settings.json
     *
     * @return void
     */
    public function generateAll()
    {
        $path = \base_path() . "/config/settings.json";

        $json = json_decode(file_get_contents($path), true);

        foreach ($json['settings'] as $value) {
            $setting = new Setting();

            $setting->type = $value['type'];
            $setting->key = $value['key'];
            $setting->value = $value['value'];

            $setting->save();

            foreach ($value['i18n'] as $valueI18n) {
                $settingI18n = new SettingsI18n();

                $settingI18n->setting_id = $setting->id;
                $settingI18n->locale = $valueI18n['locale'];
                $settingI18n->title = $valueI18n['title'];
                $settingI18n->help = $valueI18n['help'];

                $settingI18n->save();
            }
        }

        echo "All settings has been imported, congrats !";
    }
}
