<?php

namespace App\Http\Controllers;

use App\Admin;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | AdminController
    |--------------------------------------------------------------------------
    |
    | This controller handle Admin model.
    |
    */

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
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }

    /**
     * Import every addresses from current production website to local database.
     * This is used for import:all command.
     */
    public function importFromJSON()
    {
        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/admins');
        $result = json_decode($res->getBody());

        Admin::destroy(Admin::all());

        $count = 0;
        foreach($result as $r) {
            if (Admin::where('email', $r->email)->exists()) {
                continue;
            }

            $admin = new Admin();
            $admin->uuid = Str::orderedUuid();
            $admin->firstname = $r->firstname;
            $admin->lastname = $r->lastname;
            $admin->email = $r->email;
            $admin->password = $r->password;
            $admin->role = 'ADMIN';
            $admin->created_at = $r->created_at;
            $admin->updated_at = Carbon::now()->toDateTimeString();
            $admin->save();
            $count++;
        }

        echo $count . ' admins 👨‍✈️ imported !' . "\n";
    }
}
