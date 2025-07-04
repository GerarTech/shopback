<?php

return [

     'paths' => ['api/*', 'login', 'sanctum/csrf-cookie'],
    
    'allowed_origins' => ['*'], // **Change this to your frontend URL(s) for production!**
    'allowed_methods' => ['*'],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Set to true if you are using Sanctum or other cookie-based authentication

];
