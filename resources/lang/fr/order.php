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
        'CHEQUE' => 'chèque bancaire',
        'CARD' => 'carte bancaire',
    ],
    'status' => [
        'WAITING_PAYMENT' => 'en attente de paiement',
        'PROCESSING' => 'en cours de traitement',
        'DELIVERING' => 'en cours de livraison',
        'WITHDRAWAL' => 'a retirer à l\'atelier',
        'REGISTERED_PARTICIPATION' => 'participation enregistrée',
        'DELIVERED' => 'livrée',
        'CANCELED' => 'annulée',
        'REFUSED_PAYMENT' => 'paiement refusé'
    ]
];
