<?php

return [

    // 'paths' => ['api/*', 'login', 'sanctum/csrf-cookie'],
    'paths' => ['api/*', 'login'],

    'allowed_methods' => ['*'],

    'allowed_origins' =>  ['http://localhost:3000', 'https://shopify-clone-orpin.vercel.app'],
    
    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
