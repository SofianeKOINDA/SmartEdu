<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PayTech Configuration
    | Documentation : https://paytech.sn/api-doc
    |--------------------------------------------------------------------------
    */

    'api_key'    => env('PAYTECH_API_KEY', ''),
    'api_secret' => env('PAYTECH_API_SECRET', ''),

    // 'test' ou 'prod'
    'env'        => env('PAYTECH_ENV', 'test'),

    // URL de l'API PayTech
    'api_base'   => 'https://paytech.sn',
    'endpoint'   => '/api/payment/request-payment',

    // Devise (XOF = Franc CFA)
    'currency'   => 'XOF',
];
