<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\CorsMiddleware::class, // Add CorsMiddleware here
        // Other middleware...
    ];

    protected $middlewareGroups = [
        'web' => [
            // Middleware for web routes...
        ],
        'api' => [
            // Middleware for api routes...
        ],
    ];

    protected $middlewareAliases = [
        // Middleware aliases...
    ];
}
