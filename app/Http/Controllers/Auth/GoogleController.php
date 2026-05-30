<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->redirect();
    }

public function callback()
{
    $googleUser = Socialite::driver('google')
        ->user();

    // ======================
    // CARI USER BERDASARKAN EMAIL
    // ======================

    $user = User::where(

        'email',
        $googleUser->email

    )->first();

    // ======================
    // JIKA BELUM ADA USER
    // ======================

    if (!$user) {

        $user = User::create([

            'name' => $googleUser->name,

            'email' => $googleUser->email,

            'google_id' => $googleUser->id,

            'avatar' => $googleUser->avatar,

            'password' => bcrypt(
                \Illuminate\Support\Str::random(24)
            )

        ]);

    }

    // ======================
    // JIKA SUDAH ADA
    // ======================

    else {

        // tambahkan google id
        // TANPA overwrite password lama

        $user->update([

            'google_id' => $googleUser->id,

            'avatar' => $googleUser->avatar

        ]);

    }

    // ======================
    // LOGIN USER
    // ======================

    Auth::login($user);

    $token = $user
        ->createToken('auth_token')
        ->plainTextToken;

        return redirect(
            env('FRONTEND_URL', 'https://synel-coffe.vercel.app') . '/auth-success?token=' . $token
        );
}
}