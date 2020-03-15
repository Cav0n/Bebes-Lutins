<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Order Lines
    |--------------------------------------------------------------------------
    |.
    | The following language lines are shown when "trans()" helper is used in
    | orders.
    |
    */

    'payment_method' => [
        'CHEQUE' => 'bank check',
        'CARD' => 'bank card',
    ],
    'status' => [
        'WAITING_PAYMENT' => 'waiting for payment',
        'PROCESSING' => 'processing',
        'DELIVERING' => 'in delivering',
        'WITHDRAWAL' => 'to pickup at the workshop',
        'REGISTERED_PARTICIPATION' => 'registered participation',
        'DELIVERED' => 'delivered',
        'CANCELED' => 'canceled',
        'REFUSED_PAYMENT' => 'refused payment'
    ]
];
