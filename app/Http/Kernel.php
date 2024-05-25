<?php

namespace App\Http;


use Illuminate\Foundation\Http\Kernel as HttpKernel;
// use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\TrustProxies;


class Kernel extends HttpKernel
{
    protected $middleware = [
        // \App\Http\Middleware\TrustProxies::class,
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
        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    protected $middlewareAliases = [
        // Middleware aliases...
    ];

 
    
}
