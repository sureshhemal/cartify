<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // Adjust this based on your frontend domain
    'allowed_headers' => ['*'],
    'credentials' => true, // Ensure credentials are allowed
];
