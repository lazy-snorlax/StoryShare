<?php

use App\Http\Conflicts\Conflict;

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*'],
    'allowed_methods' => [
        'POST',
        'GET',
        'OPTIONS',
        'PUT',
        'PATCH',
        'DELETE',
    ],

    'allowed_origins' => [
        env('APP_URL'),
        env('FRONTEND_URL'),
        '*'
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'X-XSRF-TOKEN',
        'X-Requested-With',
        'Content-Type',
        'X-Auth-Token',
        'Origin',
        'Authorization',
        'Cache-Control',
        '*',
    ],

    'exposed_headers' => [
        'Authorization',
        'Content-Disposition'
    ],

    'max_age' => 60 * 60 * 24,

    'supports_credentials' => true,

];
