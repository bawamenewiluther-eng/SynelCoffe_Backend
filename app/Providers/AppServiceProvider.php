<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(

        function ($user, string $token) {
            // Mengambil URL dari config/env agar tidak perlu ganti kode lagi nanti
            return env('FRONTEND_URL', 'https://synel-coffe.vercel.app')
                . '/reset-password?token='
                . $token
                . '&email='
                . urlencode($user->email);
        }

            );
    }
    
}

