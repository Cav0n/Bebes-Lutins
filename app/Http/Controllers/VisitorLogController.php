<?php

namespace App\Http\Controllers;

use App\VisitorLog;
use Illuminate\Http\Request;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class VisitorLogController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | VisitorLogController
    |--------------------------------------------------------------------------
    |
    | This controller handle VisitorLog model.
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
        $currentIp = Request::ip();

        if (null === $visitorLog = VisitorLog::where('ip', $currentIp)->first) {
            $geoip = geoip()->getLocation();

            $visitorLog = new VisitorLog();
            $visitorLog->ip = $currentIp;
            $visitorLog->iso_code = $geoip->iso_code;
            $visitorLog->city = $geoip->city;
            $visitorLog->save();
        } else {
            $visitorLog->visits++;
            $visitorLog->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VisitorLog  $visitorLog
     * @return \Illuminate\Http\Response
     */
    public function show(VisitorLog $visitorLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VisitorLog  $visitorLog
     * @return \Illuminate\Http\Response
     */
    public function edit(VisitorLog $visitorLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VisitorLog  $visitorLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VisitorLog $visitorLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VisitorLog  $visitorLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(VisitorLog $visitorLog)
    {
        //
    }
}
