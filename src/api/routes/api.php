<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/sign-in', \App\Http\Controllers\Auth\LoginUserController::class)->name('sign_in');
    Route::post('/sign-up', \App\Http\Controllers\Auth\CreateUserController::class)->name('sign_up');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/sign-out', \App\Http\Controllers\Auth\LogoutUserController::class)->name('sign_out');
        Route::get('/me', \App\Http\Controllers\Auth\CurrentUserController::class)->name('me');
    });
});
