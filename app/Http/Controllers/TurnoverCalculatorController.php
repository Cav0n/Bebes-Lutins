<?php

namespace App\Http\Controllers;

use \App\TurnoverCalculator;
use Illuminate\Http\Request;

class TurnoverCalculatorController extends Controller
{
    public function calculateAll(){
        $result = array();
        $result['total'] = $this->calculateTotal();
        $result['year'] = $this->calculateCurrentYear();
        $result['month'] = $this->calculateCurrentMonth();

        header('Content-type: application/json');
        echo json_encode( $result, JSON_PRETTY_PRINT);
    }

    public function calculateTotal(){
        return TurnoverCalculator::total(\App\Order::where('status', '>=', 2)->get());
    }

    public function calculateCurrentYear(){
        return TurnoverCalculator::currentYear(\App\Order::where('status', '>=', 2)->get());
    }

    public function calculateCurrentMonth(){
        return TurnoverCalculator::currentMonth(\App\Order::where('status', '>=', 2)->get());
    }

    public function calculateCustomTurnover(Request $request){
        $result = TurnoverCalculator::custom($request['firstdate'], $request['lastdate']);
        header('Content-type: application/json');
        echo json_encode( $result, JSON_PRETTY_PRINT);
    }
}
