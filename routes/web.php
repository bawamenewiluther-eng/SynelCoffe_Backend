<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\GoogleController;

use Illuminate\Http\Request;

Route::get('/csrf-debug', function () {
    return [
        'session_id' => session()->getId(),
        'csrf_token' => csrf_token(),
        'cookie_name' => config('session.cookie'),
    ];
});
Route::get(
    '/auth/google/redirect',
    [GoogleController::class, 'redirect']
);

Route::get(
    '/auth/google/callback',
    [GoogleController::class, 'callback']
);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->post('/upload-photo', [UserController::class, 'uploadPhoto']);
Route::post('/upload-pdf', [UserController::class, 'uploadPdf'])->name('upload.pdf');
Route::get('/', function () {
    return view('welcome');
});
