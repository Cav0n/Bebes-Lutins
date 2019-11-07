<?php

namespace App;
use Carbon\Carbon;

class TurnoverCalculator
{
    public static function total($orders){
        $firstDate = Carbon::create(2018, 1, 1, 0, 0, 0);
        $now = Carbon::now();
        return TurnoverCalculator::custom($firstDate, $now, true);
    }

    public static function currentYear($orders){
        $firstDate = Carbon::create(Carbon::now()->year, 1, 1, 0, 0, 0);
        $now = Carbon::now();
        return TurnoverCalculator::custom($firstDate, $now, true);
    }

    public static function currentMonth($orders){
        $firstDate = Carbon::create(Carbon::now()->year, Carbon::now()->month, 1, 0, 0, 0);
        $now = Carbon::now();
        return TurnoverCalculator::custom($firstDate, $now, true);
    }

    public static function custom($firstDate, $lastDate, $dateIsCorrect = false){
        $turnover = 0;
        $shipping_price = 0;
        $order_count = 0;
        $items_count = 0;

        //true if dates has been created with Carbon
        if(!$dateIsCorrect){
            $firstDate = TurnoverCalculator::correctDate($firstDate);
            $lastDate = TurnoverCalculator::correctDate($lastDate);
        }

        //Calculate turnover and others...
        foreach(\App\Order::where('status', '>=', 2)->get() as $order){
            if(Carbon::parse($order->created_at)->gte($firstDate) && Carbon::parse($order->created_at)->lte($lastDate)){
                $turnover += $order->productsPrice + $order->shippingPrice;
                $shipping_price += $order->shippingPrice;
                
                $order_count++;
                foreach ($order->order_items as $item) {
                    $items_count += $item->quantity;
                }
            }
        }

        $result = [
            'turnover' => number_format($turnover, 2, ",", " "),
            'shipping_price' => number_format($shipping_price, 2, ",", " "),
            'order_count' => $order_count,
            'items_count' => $items_count
        ];

        return $result;
    }

    public static function correctDate($date){
        $correctedDate = Carbon::createFromFormat('d/m/Y H:i:s', $date);
        return $correctedDate;
    }
}
