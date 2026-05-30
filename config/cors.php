<?php

return [

    'paths' => ['paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'register'],],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['https://synel-coffe.vercel.app',],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
