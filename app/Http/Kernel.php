<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth.basic' => Middleware\BasicAuthMiddleware::class,
        'logging' => Middleware\LoggingMiddleware::class,
        'auth.adminbasic' => Middleware\AdminBasicAuthMiddleware::class
    ];
}
