<?php
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
->withMiddleware(function (Middleware $middleware) {
    $middleware->statefulApi();
    
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);

    $middleware->validateCsrfTokens(except: [
        // Gunakan /api/ untuk rute yang memang ada di api.php
        '/login', 
        '/register',
        '/logout',
        '/forgot-password',
        '/reset-password',
        
        '/api/ai-chat',
        '/api/checkout',
        '/api/save-order',
        '/api/my-orders',
        '/api/orders/update-status/*',

        '/api/menus',
        '/api/menus/*',
        '/api/menus/upload-image',
    ]);
})
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

