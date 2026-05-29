<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Artisan;

Route::get('/version-test', function () {
    return [
        'version' => 'LUTHER_TEST_123456789',
        'time' => now(),
    ];
});
Route::get('/env-test', function () {
    return [
        'SESSION_SAME_SITE_ENV' => env('SESSION_SAME_SITE'),

        'config_same_site' => config('session.same_site'),

        'hardcoded_test' => 'VERSION_999'
    ];
});
Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');

    return [
        'message' => 'cache cleared'
    ];
});

Route::get('/env-test', function () {
    return [
        'SESSION_SAME_SITE_ENV' => env('SESSION_SAME_SITE'),
        'SESSION_SECURE_COOKIE_ENV' => env('SESSION_SECURE_COOKIE'),
        'config_same_site' => config('session.same_site'),
        'config_secure' => config('session.secure'),
    ];
});
Route::get('/env-test', function () {
    return [
        'SESSION_SAME_SITE_ENV' => env('SESSION_SAME_SITE'),
        'SESSION_SECURE_COOKIE_ENV' => env('SESSION_SECURE_COOKIE'),

        'config_same_site' => config('session.same_site'),
        'config_secure' => config('session.secure'),
    ];
});
Route::post(
    '/ai-chat',
    [PaymentController::class,
    'aiChat']

);
Route::post(

    '/my-orders',

    [PaymentController::class,
    'myOrders']

);
Route::post(

    '/orders/update-status/{id}',

    [PaymentController::class,
    'updateOrderStatus']

);
Route::get(
    '/orders',
    [PaymentController::class, 'getOrders']
);
Route::post(
    '/save-order',
    [PaymentController::class, 'saveOrder']
);
Route::post(

    '/checkout',

    [PaymentController::class, 'checkout']

);

Route::delete(
    '/menus/{id}',
    [MenuController::class, 'destroy']
);
Route::post(
    '/menus',
    [MenuController::class, 'store']
);
Route::put(
    '/menus/{id}',
    [MenuController::class, 'update']
);

Route::post(
    '/menus/upload-image',
    [MenuController::class, 'uploadImage']
);
Route::get('/menus', [MenuController::class, 'index']);

Route::middleware('auth:sanctum')->get(
    '/user',
    function (Request $request) {

        return $request->user();

    }
);
Route::middleware([
    'auth:sanctum',
    'admin'
])->group(function () {

    Route::post(
        '/menus',
        [MenuController::class, 'store']
    );

    Route::put(
        '/menus/{id}',
        [MenuController::class, 'update']
    );

    Route::delete(
        '/menus/{id}',
        [MenuController::class, 'destroy']
    );

    Route::post(
        '/menus/upload-image',
        [MenuController::class, 'uploadImage']
    );

});
Route::post('/forgot-password', function (Request $request) {

    $request->validate([

        'email' => 'required|email'

    ]);

    $status = Password::sendResetLink(

        $request->only('email')

    );

    return $status === Password::RESET_LINK_SENT

        ? response()->json([

            'message' => 'Link reset berhasil dikirim'

        ])

        : response()->json([

            'message' => 'Gagal mengirim link reset'

        ], 400);

});
Route::post('/reset-password', function (Request $request) {

    $request->validate([

        'token' => 'required',

        'email' => 'required|email',

        'password' => 'required|min:8|confirmed',

    ]);

    $status = Password::reset(

        $request->only(

            'email',

            'password',

            'password_confirmation',

            'token'

        ),

        function (User $user, string $password) {

            $user->forceFill([

                'password' => Hash::make($password)

            ])->setRememberToken(

                Str::random(60)

            );

            $user->save();

            event(new PasswordReset($user));

        }

    );

    return $status === Password::PASSWORD_RESET

        
? response()->json([

            'message' => 'Password berhasil direset'

        ])

        : response()->json([

            'message' => 'Reset password gagal'

        ], 400);

});