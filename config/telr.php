<?php
return [
    'store_id' => env('TELR_STORE_ID'),
    'auth_key' => env('TELR_AUTH_KEY'),
    'test_mode' => env('TELR_TEST_MODE', true),
    'api_url' => env('TELR_API_URL', 'https://secure.telr.com/gateway/order.json'),
    'default_currency' => env('TELR_DEFAULT_CURRENCY', 'SAR'),
    'timeout' => env('TELR_TIMEOUT', 30),
    
];
