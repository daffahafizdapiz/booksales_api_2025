<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Configuration
    |--------------------------------------------------------------------------
    |
    | Ini akan mengatur agar API Laravel bisa diakses oleh frontend React.js
    | dari localhost:5173 tanpa error CORS.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:5173',
        'http://127.0.0.1:5173',
        // Tambahkan domain frontend lain kalau perlu:
        // 'https://your-frontend-domain.com',
    ],

    'allowed_origins_patterns' => ['http://localhost:5173'],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
