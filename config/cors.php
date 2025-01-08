<?php
return [
    'paths' => ['*'], // Rutas a las que se aplicará CORS
    'allowed_methods' => ['*'], // Permite todos los métodos
    'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:3000')], // Especifica tu frontend
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization', 'X-CSRF-TOKEN'],
    'exposed_headers' => ['Authorization', 'X-CSRF-TOKEN'],
    'max_age' => 0,
    'supports_credentials' => false, // Importante para withCredentials
];
