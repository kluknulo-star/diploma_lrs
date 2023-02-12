<?php

use App\Access\Login\Http\Controllers\ForgotPasswordController;
use App\Access\Login\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);
    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])
        ->name('forget.password.get');
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])
        ->name('forget.password.post');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])
        ->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])
        ->name('reset.password.post');
});

Route::get('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

