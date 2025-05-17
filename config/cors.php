<?php
return [
    'paths' => ['api/*', 'login', 'logout'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:3001', 'http://localhost:3000', 'http://127.0.0.1:8000'],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];