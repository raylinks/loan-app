<?php

return [

    'public_key' => env('BLACKLIST_PUBLIC_KEY'),

    'secret_key' => env('BLACKLIST_SECRET_KEY'),

    // Payment Url from  Blacklist
    'base_url' => env('BLACKLIST_PAYMENT_URL'),

    // Optional email address of the merchant
    'merchant_email' => env('MERCHANT_EMAIL'),

];
