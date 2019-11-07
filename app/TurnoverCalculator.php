<?php

namespace App;
use Carbon\Carbon;

class TurnoverCalculator
{
    public static function total($orders){
        $turnover_total = 0;
        $shipping_price_total = 0;
        $items_count_total = 0;
        $order_count_total = 0;
        foreach($orders as $order){
            $turnover_total += $order->productsPrice + $order->shippingPrice;
            $shipping_price_total += $order->shippingPrice;

            $order_count_total++;

            foreach ($order->order_items as $item) {
                $items_count_total += $item->quantity; 
            }
        }
        $result = [
            'turnover' => number_format($turnover_total, 2, ",", " "),
            'shipping_price' => number_format($shipping_price_total, 2, ",", " "),
            'order_count' => $order_count_total,
            'items_count' => $items_count_total
        ];
        return $result;
    }

    public static function currentYear($orders){
        $turnover_of_the_year = 0;
        $shipping_price_of_the_year = 0;
        $order_count_year = 0;
        $items_count_year = 0;
        foreach($orders as $order){
            if(Carbon::parse($order->created_at)->gte(Carbon::create(Carbon::now()->year, 1, 1, 0, 0, 0))){
                $turnover_of_the_year += $order->productsPrice + $order->shippingPrice;
                $shipping_price_of_the_year += $order->shippingPrice;

                $order_count_year++;
                foreach ($order->order_items as $item) {
                    $items_count_year += $item->quantity;
                }
            }
        }

        $result = [
            'turnover' => number_format($turnover_of_the_year, 2, ",", " "),
            'shipping_price' => number_format($shipping_price_of_the_year, 2, ",", " "),
            'order_count' => $order_count_year,
            'items_count' => $items_count_year
        ];
        return $result;
    }

    public static function currentMonth($orders){
        $turnover_of_the_month = 0;
        $shipping_price_of_the_month = 0;
        $order_count_month = 0;
        $items_count_month = 0;
        foreach($orders as $order){
            if(Carbon::parse($order->created_at)->gte(Carbon::create(Carbon::now()->year, Carbon::now()->month, 1, 0, 0, 0))){
                $turnover_of_the_month += $order->productsPrice + $order->shippingPrice;
                $shipping_price_of_the_month += $order->shippingPrice;
                
                $order_count_month++;
                foreach ($order->order_items as $item) {
                    $items_count_month += $item->quantity;
                }
            }
        }

        $result = [
            'turnover' => number_format($turnover_of_the_month, 2, ",", " "),
            'shipping_price' => number_format($shipping_price_of_the_month, 2, ",", " "),
            'order_count' => $order_count_month,
            'items_count' => $items_count_month
        ];
        return $result;
    }

    public static function custom($firstDate, $lastDate){
        $turnover_custom = 0;
        $shipping_price_custom = 0;
        $order_count_custom = 0;
        $items_count_custom = 0;

        $firstDate = TurnoverCalculator::correctDate($firstDate);
        $lastDate = TurnoverCalculator::correctDate($lastDate);

        foreach(\App\Order::where('status', '>=', 2)->get() as $order){
            if(Carbon::parse($order->created_at)->gte($firstDate) && Carbon::parse($order->created_at)->lte($lastDate)){
                $turnover_custom += $order->productsPrice + $order->shippingPrice;
                $shipping_price_custom += $order->shippingPrice;
                
                $order_count_custom++;
                foreach ($order->order_items as $item) {
                    $items_count_custom += $item->quantity;
                }
            }
        }

        $result = [
            'turnover' => number_format($turnover_custom, 2, ",", " "),
            'shipping_price' => number_format($shipping_price_custom, 2, ",", " "),
            'order_count' => $order_count_custom,
            'items_count' => $items_count_custom
        ];

        header('Content-type: application/json');
        echo json_encode( $result, JSON_PRETTY_PRINT);
    }

    public static function correctDate($date){
        $correctedDate = Carbon::createFromFormat('d/m/Y H:i:s', $date);
        return $correctedDate;
    }
}
