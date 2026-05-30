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
        // Rute Auth Bawaan
        '/login',
        '/register',
        '/logout',
        '/api/forgot-password',
            '/api/reset-password',

        // Rute AI & Chat
        '/api/ai-chat',

        // Rute Payment & Orders (User & Admin)
        '/api/checkout',
        '/api/save-order',
        '/api/my-orders',
        '/api/orders/update-status/*', // Wildcard untuk ID pesanan

        // Rute Manajemen Menu (Admin)
        '/api/menus',               // Untuk POST (tambah menu)
        '/api/menus/*',             // Untuk PUT & DELETE (update/hapus menu)
        '/api/menus/upload-image',
    ]);
})
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

