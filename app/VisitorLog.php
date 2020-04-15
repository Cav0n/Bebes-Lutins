<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class VisitorLog extends Model
{
    public static function log()
    {
        $currentIp = Request::ip();

        if (null === $visitorLog = VisitorLog::where('ip', $currentIp)->first()) {
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
}
