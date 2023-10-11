<?php
return [
    'IPaymu_URL'     => env('IPaymu_URL'),
    'IPaymu_VA'     => env('IPaymu_VA'),
    'IPaymu_APIKEY' => env('IPaymu_APIKEY'),
    'Google_APIKEY' => env('Google_APIKEY'),
    'SDWAN_Aggregator_URL' => env('SDWAN_AGGREGATOR_URL'),
    'SDWAN' => [
        'email' => env('SDWAN_EMAIL'),
        'password' => env('SDWAN_PASSWORD'),
        'parent_name' => env('SDWAN_PARENT_NAME'),
        'parent_url' => env('SDWAN_PARENT_URL'),
    ]
];
?>
