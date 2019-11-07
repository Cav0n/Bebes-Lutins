<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TurnoverCalculatorController extends Controller
{
    public function calculateCustomTurnover(Request $request){
        \App\TurnoverCalculator::custom($request['firstdate'], $request['lastdate']);
    }
}
