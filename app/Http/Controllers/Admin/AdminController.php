<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Handle some page redirection in admin backoffice.
 */
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return redirect(route('admin.homepage'));
    }

    public function homepage()
    {
        $analytics = [];
        $analytics['total']['orders'] = 0;
        $analytics['total']['customers'] = 0;
        $analytics['total']['ordersCost'] = 0;
        $analytics['total']['civility']['mister'] = 0;
        $analytics['total']['civility']['miss'] = 0;
        $totalOfMister = 0;
        $totalOfMiss = 0;
        $period = \Carbon\CarbonPeriod::create(
            \Carbon\Carbon::now()->subDays(30), '1 day',
            \Carbon\Carbon::now());

        $index = 0;
        foreach($period as $date)
        {
            $analytics['orders'][$index]['date'] = $date->format('d / m');
            $analytics['orders'][$index]['value'] = \App\Order::whereDate('created_at', $date)->count();

            $analytics['customers'][$index]['date'] = $date->format('d / m');
            $analytics['customers'][$index]['value'] = \App\User::whereDate('created_at', $date)->count();

            $analytics['ordersCost'][$index]['date'] = $date->format('d / m');
            $totalOfTheDay = 0;

            foreach (\App\Order::whereDate('created_at', $date)->get() as $order) {
                $totalOfTheDay += $order->items->sum('unitPrice');
                $totalOfMister += "MISTER" === $order->billingAddress->civility ? 1 : 0;
                $totalOfMiss += "MISS" === $order->billingAddress->civility ? 1 : 0;
            }
            $analytics['ordersCost'][$index]['value'] = $totalOfTheDay;

            $analytics['total']['orders'] += \App\Order::whereDate('created_at', $date)->count();
            $analytics['total']['customers'] += \App\User::whereDate('created_at', $date)->count();
            $analytics['total']['ordersCost'] += $totalOfTheDay;

            $index++;
        }

        $analytics['total']['civility']['mister'] = $totalOfMister;
        $analytics['total']['civility']['miss'] = $totalOfMiss;

        return view('pages.admin.homepage')->with('analytics', $analytics);
    }
}
