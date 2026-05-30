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
        
        $middleware->validateCsrfTokens(except: [
            '/login',
            '/register',
            '/logout',
            '/api/ai-chat',    // Sesuaikan dengan path rute AI kamu
            '/api/checkout',   // Sesuaikan dengan path rute Checkout kamu
            '/api/save-order', // Agar simpan order juga lancar
            'midtrans/callback' // WAJIB: agar Midtrans bisa kirim notifikasi ke backend
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

