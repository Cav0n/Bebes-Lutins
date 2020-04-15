<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use Illuminate\Http\JsonResponse;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class AnalyticsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | [ADMIN] - AnalyticsController
    |--------------------------------------------------------------------------
    |
    | This controller handle analytics (showed on homepage).
    |
    */

    protected const DATE_FORMAT = 'd/m/Y';

    /** @var string $class */
    protected $class;

    /** @var array $period */
    protected $period;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        // Todo : secure API and verify if class exists
        $this->class = '\App\\' . ucfirst($request['class']);
        $this->prepareDate($request);
    }

    /**
     * Prepared first date, last date and period for analytics.
     *
     * @param Request $request The request with or without param ['firstdate'],
     *                         ['lastdate'], and ['stepDate'].
     * @return array Return an array all dates in the period.
     */
    protected function prepareDate(Request $request)
    {
        $dates = [];

        $firstDate = isset($request['firstDate']) && $request['firstDate'] ?
        Carbon::createFromFormat(self::DATE_FORMAT, $request['firstDate']) :
        Carbon::now()->subDays(30);

        $lastDate = isset($request['lastDate']) && $request['lastDate'] ?
        Carbon::createFromFormat(self::DATE_FORMAT, $request['lastDate']) :
        Carbon::now();

        $stepDate = isset($request['stepDate']) && $request['stepDate'] ? $request['stepDate'] : '1 day';

        $this->period = CarbonPeriod::create(
                            $firstDate,
                            $stepDate,
                            $lastDate);
    }

    /**
     * Analytic by counting model created during period.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function analyticCount()
    {
        $data = [];
        $data['total'] = 0;
        $data['max'] = 0;
        $data['period'] = $this->period;

        $index = 0;
        foreach ($this->period as $date) {
            $modelCount = $this->class::whereDate('created_at', $date)->count();
            $data[$index]['date'] = $date->format('m/d/Y H:i');
            $data[$index]['value'] = $modelCount;
            $data['total'] += $modelCount;

            $data['max'] < $modelCount ? $data['max'] = $modelCount : null;

            $index++;
        }

        return JsonResponse::create($data, 200);
    }

    /**
     * Analytic for sales done during period.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sales()
    {
        $data = [];
        $data['total'] = 0;
        $data['max'] = 0;
        $data['period'] = $this->period;
        $orderIds = [];

        $index = 0;
        foreach ($this->period as $date) {
            $orders = \App\Order::whereDate('created_at', $date)->get();
            $data[$index]['date'] = $date->format('m/d/Y H:i'); // Todo: create a constante FORMAT_WITH_STEP for step like 1 hour.
            $data[$index]['value'] = 0;

            foreach ($orders as $order) {
                if(! \in_array($order->id, $orderIds)) {
                    $orderIds[] = $order->id; // Fix to not count multiple times one order (when on a scale of a day)
                    foreach ($order->items as $item) {
                        $data[$index]['value'] += $item->unitPrice * $item->quantity;
                        $data['total'] += $item->unitPrice * $item->quantity;
                    }
                }
            }

            $data['max'] < $data[$index]['value'] ? $data['max'] = $data[$index]['value'] : null;

            $index++;
        }

        return JsonResponse::create($data, 200);
    }

    /**
     * Analytic for visits.
     *
     * @return void
     */
    public function visits()
    {
        $data = [];
        $data['total'] = 0;
        $data['max'] = 0;
        $data['period'] = $this->period;

        $index = 0;
        foreach ($this->period as $date) {
            $visitors = \App\VisitorLog::whereDate('created_at', $date)->get();
            $data[$index]['date'] = $date->format('m/d/Y H:i'); // Todo: create a constante FORMAT_WITH_STEP for step like 1 hour.
            $data[$index]['value'] = 0;

            foreach ($visitors as $visitor) {
                $data[$index]['value'] += $visitor->visits;
                $data['total'] += $visitor->visits;
            }

            $data['max'] < $data[$index]['value'] ? $data['max'] = $data[$index]['value'] : null;

            $index++;
        }

        return JsonResponse::create($data, 200);
    }
}
